<?php namespace App\Modules\OutgoingMail\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Upload;
class OutgoingMailAttachment extends Model
{
	
	protected $table = 'outgoing_mails_attachment';
	
    protected $fillable   = [
		'outgoing_mail_id', 'attachment_name', 'attachment_order', 'path_to_file', 'status'
	];
	
	protected static function boot() 
    {
		parent::boot();

		static::deleting(function($attachment) {
			/* Remove attachment file*/
			if (!empty($attachment->path_to_file)) {
				Upload::delete($attachment->path_to_file);
			}
		});
    }
}