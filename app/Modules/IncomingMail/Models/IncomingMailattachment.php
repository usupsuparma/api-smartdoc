<?php namespace App\Modules\IncomingMail\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Upload;

class IncomingMailAttachment extends Model
{
	
	protected $table = 'incoming_mails_attachment';
	
    protected $fillable   = [
		'incoming_mail_id', 'attachment_name', 'attachment_order', 'path_to_file', 'status'
	];
	
	protected static function boot() 
    {
		parent::boot();

		static::deleting(function($attachment) {
			/* Remove attachment file*/
			Upload::delete($attachment->path_to_file);
		});
    }
}