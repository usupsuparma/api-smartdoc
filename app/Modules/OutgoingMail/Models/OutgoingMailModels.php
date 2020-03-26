<?php namespace App\Modules\OutgoingMail\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\OutgoingMail\Transformers\OutgoingMailTransformer;
use App\Modules\OutgoingMail\Models\OutgoingMailAttachment;
use App\Modules\OutgoingMail\Models\OutgoingMailApproval;
use App\Modules\OutgoingMail\Models\OutgoingMailForward;

class OutgoingMailModel extends Model
{
	use SoftDeletes;

	public $transformer = OutgoingMailTransformer::class;
	
	protected $table = 'outgoing_mails';
	
    protected $fillable   = [
		'subject_letter', 'number_letter', 'type_id', 'classification_id', 'letter_date', 'to_employee_id',
		'from_employee_id','body', 'status', 'signed', 'retension_date', 'path_to_file', 'approval_id', 'created_by_employee','created_by_structure'
	];
	
	protected $dates = ['deleted_at'];
	
	public function attachments()
	{
		return $this->hasMany(OutgoingMailAttachment::class, 'outgoing_mail_id');
	}
	
	public function approvals()
	{
		return $this->hasMany(OutgoingMailApproval::class, 'outgoing_mail_id');
	}
	
	public function forwards()
	{
		return $this->hasMany(OutgoingMailForward::class, 'outgoing_mail_id');
	}
	
	protected static function boot() 
    {
		parent::boot();

		static::deleting(function($mails) {
			/* Remove relation attachment */
			foreach ($mails->attachments()->get() as $attachment) {
				$attachment->delete();
			}
			
			/* Remove relation approvals */
			foreach ($mails->approvals()->get() as $approval) {
				$approval->delete();
			}
			
			/* Remove relation forwards */
			foreach ($mails->forwards()->get() as $forward) {
				$forward->delete();
			}
		});
    }
}