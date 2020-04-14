<?php namespace App\Modules\OutgoingMail\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\External\Organization\Models\OrganizationModel;

class OutgoingMailApproval extends Model
{
	
	protected $table = 'outgoing_mails_approval';
	
    protected $fillable   = [
		'outgoing_mail_id', 'structure_id', 'employee_id', 'status_approval', 'description',
		'is_review', 'status'
	];
	
	public function employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'employee_id', 'id_employee');
	}
	
	public function structure()
	{
		return $this->belongsTo(OrganizationModel::class, 'structure_id');
	}
}