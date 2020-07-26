<?php namespace App\Modules\Disposition\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Disposition\Transformers\DispositionTransformer;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\Disposition\Models\DispositionAssign;
use App\Modules\Signature\Models\SignatureModel;
use App\Modules\IncomingMail\Models\IncomingMailModel;
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use Auth, Upload, DB;

class DispositionModel extends Model
{
	use SoftDeletes;

	public $transformer = DispositionTransformer::class;
	
	protected $table = 'dispositions';
	
    protected $fillable   = [
		'incoming_mail_id', 'number_disposition', 'subject_disposition', 'disposition_date', 'from_employee_id',
		'description', 'status', 'is_archive', 'path_to_file'
	];
	
	protected $dates = ['deleted_at'];
	
	public function incoming()
	{
		return $this->belongsTo(IncomingMailModel::class, 'incoming_mail_id');
	}
	
	public function assign()
	{
		return $this->hasMany(DispositionAssign::class, 'disposition_id', 'id');
	}
	
	public function employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'from_employee_id', 'id_employee');
	}
	
	public function signature()
	{
		return $this->belongsTo(SignatureModel::class, 'from_employee_id', 'employee_id');
	}
	
	public function scopeAuthorityData($query)
	{
		$employee_id = Auth::user()->user_core->id_employee;
		
		if (Auth::user()->role->categories === 'management') {
			return $query->where('from_employee_id', $employee_id);
		} 
		
		return $query;
	}
	
	public function scopeFollowUpEmployee($query)
	{
		$employee_id = Auth::user()->user_core->employee->id_employee;
		
		return $query->whereHas('assign', function ($q) use ($employee_id) {
			$q->where('employee_id', $employee_id);
		})->where([
			'status' => IncomingMailStatusConstans::DISPOSITION,
		]);
	}
	
	public function scopeMaxNumber($query, $format)
	{
		return $query->select(DB::raw('max(number_disposition) as max_number'))
			->where('number_disposition', 'like', "%{$format}%")
			->whereMonth('created_at', date('m'))
			->whereYear('created_at', date('Y'))
			->first();
	}
	
	public function scopeIsDisposition($query, $id)
	{	
		return $query->whereIn(
			'status', [
				IncomingMailStatusConstans::DISPOSITION,
				IncomingMailStatusConstans::DONE,
			]
		)->where('id', $id);
	}
	
	public function scopeCategoryReport($query)
	{
		$category = [
			IncomingMailStatusConstans::DISPOSITION,
			IncomingMailStatusConstans::DONE
		];
		
		return $query->whereIn('status', $category);
	}
	
	public function scopeIsArchive($query) 
	{
		return $query->where('is_archive', IncomingMailStatusConstans::IS_ARCHIVE);
	}
	
	public function scopeIsNotArchive($query) 
	{
		return $query->where('is_archive', IncomingMailStatusConstans::IS_NOT_ARCHIVE);
	}
	
	
	protected static function boot() 
    {
		parent::boot();

		static::deleting(function($dispo) {
			/* Remove main file*/
			Upload::delete($dispo->path_to_file);
			
			/* Remove relation assign */
			foreach ($dispo->assign()->get() as $assign) {
				$assign->delete();
			}
		});
    }
}