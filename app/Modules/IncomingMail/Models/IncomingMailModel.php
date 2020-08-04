<?php namespace App\Modules\IncomingMail\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\IncomingMail\Transformers\IncomingMailTransformer;
use App\Modules\IncomingMail\Models\IncomingMailAttachment;
use App\Modules\IncomingMail\Models\IncomingMailFollowUp;
use App\Modules\Master\Type\Models\TypeModel;
use App\Modules\Master\Classification\Models\ClassificationModel;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\External\Organization\Models\OrganizationModel;
use App\Modules\Disposition\Models\DispositionModel;
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use App\Helpers\SmartdocHelper;
use Auth, Upload;

class IncomingMailModel extends Model
{
	use SoftDeletes;

	public $transformer = IncomingMailTransformer::class;
	
	protected $table = 'incoming_mails';
	
    protected $fillable   = [
		'subject_letter', 'number_letter', 'type_id', 'classification_id', 'letter_date', 'recieved_date',
		'sender_name', 'receiver_name', 'structure_id', 'to_employee_id', 'status', 'is_recieved', 'retension_date', 
		'is_archive', 'path_to_file', 'is_read'
	];
	
	protected $dates = ['deleted_at'];
	
	public function attachments()
	{
		return $this->hasMany(IncomingMailAttachment::class, 'incoming_mail_id', 'id');
	}
	
	public function follow_ups()
	{
		return $this->hasMany(IncomingMailFollowUp::class, 'incoming_mail_id', 'id');
	}
	
	public function type()
	{
		return $this->belongsTo(TypeModel::class, 'type_id');
	}
	
	public function classification()
	{
		return $this->belongsTo(ClassificationModel::class, 'classification_id');
	}
	
	public function to_employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'to_employee_id', 'id_employee');
	}
	
	public function structure()
	{
		return $this->belongsTo(OrganizationModel::class, 'structure_id');
	}
	
	public function disposition()
	{
		return $this->hasOne(DispositionModel::class, 'incoming_mail_id');
	}
	
	public function redisposition()
	{
		return $this->hasOne(DispositionModel::class, 'incoming_mail_id')
					->where('from_employee_id', Auth::user()->user_core->employee->id_employee)
					->where('is_redisposition', 1);
	}
	
	public function scopeAuthorityData($query)
	{
		$employee_id = Auth::user()->user_core->id_employee;
		
		if (Auth::user()->role->categories === 'management') {
			return $query->where('to_employee_id', $employee_id);
		} 
		
		return $query;
	}
	
	public function scopeFollowUpEmployee($query)
	{
		$employee_id = Auth::user()->user_core->employee->id_employee;
		
		return $query->where([
			'to_employee_id' => $employee_id,
			'status' => IncomingMailStatusConstans::SEND,
		]);
	}
	
	public function scopeFollowUpEmployeeAutoFollow($query)
	{
		$employee_id = Auth::user()->user_core->employee->id_employee;
		
		return $query->where([
			'to_employee_id' => $employee_id
		])->whereIn(
			'status', [
				IncomingMailStatusConstans::SEND,
				IncomingMailStatusConstans::DONE,
			]
		);
	}
	
	public function scopeOptions($query, $default = NULL)
    {
		$list = [];
		$query->with('disposition')->where([
			'to_employee_id' => Auth::user()->user_core->employee->id_employee
		]);
		
		/* Condition if strukture without BOD LEVEL */
		if (!SmartdocHelper::bod_level()) {
			$query->where('status', IncomingMailStatusConstans::DONE);
		}

		$filtered = $query->orderBy('number_letter')->get()->filter(function ($value, $key) {
			return empty($value->disposition);
		});
		
		if (!empty($filtered->all())) {
			foreach ($filtered->all() as $dt) {
				$list[] = [
					'id' => $dt->id,
					'number_letter' => $dt->number_letter,
					'subject_letter' => $dt->subject_letter,
				];
			}
		}
        
        return $list;
	}
	
	public function scopeOptionRedispositions($query)
	{
		$list = [];
		$query->whereHas('disposition', function ($q){
			$q->whereHas('assign', function ($assign){
				$assign->where('employee_id', Auth::user()->user_core->employee->id_employee);
			});
		});
		
		$filtered = $query->orderBy('number_letter')->get()->filter(function ($value, $key) {
			return empty($value->redisposition);
		});
		
		if (!empty($filtered->all())) {
			foreach ($filtered->all() as $dt) {
				$list[] = [
					'id' => $dt->id,
					'number_letter' => $dt->number_letter,
					'subject_letter' => $dt->subject_letter,
				];
			}
		}
        
        return $list;
	}
	
	public function scopeIsArchive($query) 
	{
		return $query->where('is_archive', IncomingMailStatusConstans::IS_ARCHIVE);
	}
	
	public function scopeIsNotArchive($query) 
	{
		return $query->where('is_archive', IncomingMailStatusConstans::IS_NOT_ARCHIVE);
	}
	
	public function scopeIsDone($query) 
	{
		return $query->where('status', IncomingMailStatusConstans::DONE);
	}
	
	protected static function boot() 
    {
		parent::boot();

		static::deleting(function($mails) {
			/* Remove main file*/
			Upload::delete($mails->path_to_file);
			
			/* Remove relation attachment */
			foreach ($mails->attachments()->get() as $attachment) {
				$attachment->delete();
			}
			
			/* Remove relation approvals */
			foreach ($mails->follow_ups()->get() as $fu) {
				$fu->delete();
			}
		});
    }
}