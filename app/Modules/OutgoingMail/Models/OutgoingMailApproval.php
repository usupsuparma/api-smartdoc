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
		'path_to_file', 'is_review', 'status'
	];
	
	public function employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'employee_id', 'id_employee');
	}
	
	public function structure()
	{
		return $this->belongsTo(OrganizationModel::class, 'structure_id');
	}
	
	public function scopeByMailId($query, $outgoing_mail_id)
	{
		return $query->where('outgoing_mail_id', $outgoing_mail_id);
	}
	
	public function scopeNextApproval($query, $outgoing_mail_id)
	{
		$model = $query->byMailId($outgoing_mail_id)
				->where('status', true)
				->whereNull('status_approval')
				->get();
		
		return $model;
	}
}