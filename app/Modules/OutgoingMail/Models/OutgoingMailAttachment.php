<?php namespace App\Modules\OutgoingMail\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;

class OutgoingMailAttachment extends Model
{
	
	protected $table = 'outgoing_mails_attachment';
	
    protected $fillable   = [
		'outgoing_mail_id', 'attachment_name', 'attachment_order', 'path_to_file', 'status'
	];
}