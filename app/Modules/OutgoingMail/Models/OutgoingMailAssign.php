<?php namespace App\Modules\OutgoingMail\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use App\Modules\External\Organization\Models\OrganizationModel;
use App\Modules\OutgoingMail\Models\OutgoingMailFollowUp;

class OutgoingMailAssign extends Model
{
	
	protected $table = 'outgoing_mails_assign';
	
    protected $fillable   = [
		'outgoing_mail_id', 'structure_id', 'employee_id'
	];
	
	public function outgoing_mail()
	{
		return $this->belongsTo(OutgoingMailModel::class, 'outgoing_mail_id');
	}
	
	public function follow_ups()
	{
		return $this->hasMany(OutgoingMailFollowUp::class, 'outgoing_mails_assign_id');
	}
	
	public function employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'employee_id', 'id_employee');
	}
	
	public function structure()
	{
		return $this->belongsTo(OrganizationModel::class, 'structure_id');
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