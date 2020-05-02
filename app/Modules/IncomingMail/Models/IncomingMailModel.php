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
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use Auth, Upload;

class IncomingMailModel extends Model
{
	use SoftDeletes;

	public $transformer = IncomingMailTransformer::class;
	
	protected $table = 'incoming_mails';
	
    protected $fillable   = [
		'subject_letter', 'number_letter', 'type_id', 'classification_id', 'letter_date', 'recieved_date',
		'sender_name', 'receiver_name', 'structure_id', 'to_employee_id', 'status', 'is_recieved', 'retension_date', 
		'path_to_file'
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
	
	public function scopeOptions($query, $default = NULL)
    {
        $list = [];
		$query->where([
			'to_employee_id' => Auth::user()->user_core->employee->id_employee,
			'status' => IncomingMailStatusConstans::DONE,
		]);
		
        foreach ($query->orderBy('number_letter')->get() as $dt) {
            $list[] = [
				'id' => $dt->id,
				'number_letter' => $dt->number_letter,
				'subject_letter' => $dt->subject_letter,
			];
		}
		
        return $list;
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