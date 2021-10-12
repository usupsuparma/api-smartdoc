<?php namespace App\Modules\Disposition\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\Disposition\Models\DispositionModel;
use App\Modules\External\Organization\Models\OrganizationModel;
use App\Modules\Disposition\Models\DispositionFollowUp;
use App\Modules\Master\ClassDisposition\Models\ClassDispositionModel;
use Auth;

class DispositionAssign extends Model
{
	
	protected $table = 'dispositions_assign';
	
    protected $fillable   = [
		'disposition_id', 'structure_id', 'employee_id', 'classification_disposition_id', 'is_read'
	];
	
	public function disposition()
	{
		return $this->belongsTo(DispositionModel::class, 'disposition_id');
	}
	
	public function follow_ups()
	{
		return $this->hasMany(DispositionFollowUp::class, 'dispositions_assign_id');
	}
	
	public function employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'employee_id', 'id_employee');
	}
	
	public function structure()
	{
		return $this->belongsTo(OrganizationModel::class, 'structure_id');
	}
	
	public function class_disposition()
	{
		return $this->belongsTo(ClassDispositionModel::class, 'classification_disposition_id');
	}
	
	public function scopeCheckRead($query, $disposition_id) 
	{
		$nik = Auth::user()->user_core->id_employee;
		$employee = EmployeeModel::GetEmployeeByNik($nik);
		return $query->where([
			'employee_id' => $employee->id_employee,
			'disposition_id' => $disposition_id
		])->first();
		
	}
	protected static function boot() 
    {
		parent::boot();

		static::deleting(function($assign) {
			/* Remove relation */
			foreach ($assign->follow_ups()->get() as $follow) {
				$follow->delete();
			}
		});
    }
}