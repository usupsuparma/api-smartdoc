<?php namespace App\Modules\OutgoingMail\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\OutgoingMail\Models\OutgoingMailAssign;
use Upload;

class OutgoingMailFollowUp extends Model
{
	
	protected $table = 'outgoing_mails_follow_up';
	
    protected $fillable   = [
		'outgoing_mails_assign_id', 'employee_id', 'description', 'path_to_file', 'status'
	];
	
	public function employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'employee_id', 'id_employee');
	}
	
	public function assign()
	{
		return $this->belongsTo(OutgoingMailAssign::class, 'outgoing_mails_assign_id');
	}
	
	protected static function boot() 
    {
		parent::boot();

		static::deleting(function($followup) {
			/* Remove attachment file*/
			if (!empty($followup->path_to_file)) {
				Upload::delete($followup->path_to_file);
			}
		});
    }
}