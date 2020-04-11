<?php namespace App\Modules\OutgoingMail\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\External\Employee\Models\EmployeeModel;
class OutgoingMailForward extends Model
{
	
	protected $table = 'outgoing_mails_forward';
	
    protected $fillable   = [
		'outgoing_mail_id', 'employee_id'
	];
	
	public function employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'employee_id', 'id_employee');
	}
}