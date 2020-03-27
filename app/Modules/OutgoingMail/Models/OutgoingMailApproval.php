<?php namespace App\Modules\OutgoingMail\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;

class OutgoingMailApproval extends Model
{
	
	protected $table = 'outgoing_mails_approval';
	
    protected $fillable   = [
		'outgoing_mail_id', 'employee_id', 'status_approval', 'description'
	];
}