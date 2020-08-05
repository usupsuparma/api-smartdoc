<?php namespace App\Modules\OutgoingMail\Repositories;
/**
 * Class SignedOutgoingMailRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\OutgoingMail\Interfaces\SignedOutgoingMailInterface;
use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use App\Modules\OutgoingMail\Transformers\OutgoingMailTransformer;
use App\Modules\Signature\Models\SignatureModel;
use App\Modules\OutgoingMail\Constans\OutgoingMailStatusConstants;
use Validator, Upload, DigitalSign, Smartdoc;
use App\Constants\EmailConstants;
use Illuminate\Support\Facades\Crypt;
use App\Jobs\SendEmailReminderJob;
use App\Events\Notif;
use App\Constants\MailCategoryConstants;

class SignedOutgoingMailRepositories extends BaseRepository implements SignedOutgoingMailInterface
{
	public function model()
	{
		return OutgoingMailModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->signedEmployee();
		
		if ($request->has('keyword') && !empty($request->keyword)) {
			$query->where('subject_letter', 'like', "%{$request->keyword}%");
		}
		
		if ($request->has('type_id') && !empty($request->type_id)) {
			$query->where('type_id', $request->type_id);
		}
		
		if ($request->has('classification_id') && !empty($request->classification_id)) {
			$query->where('classification_id', $request->classification_id);
		}
		
		if ($request->has('start_date') &&  $request->has('end_date')) {
			if (!empty($request->start_date) && !empty($request->end_date)) {
				$query->whereBetween('letter_date', [$request->start_date, $request->end_date]);	
			}
		}
		
		return $query->get();
	}
	
	public function show($id)
    {
		$data =  $this->model->signedEmployee()->where('id', $id)->firstOrFail();
		
		return ['data' => OutgoingMailTransformer::customTransform($data)];
	}
	
	public function update($request, $id)
    {
		$model = $this->model->signedEmployee()->where('id', $id)->firstOrFail();

		if ($request->signature_available) {
			$rules = [
				'credential_key' => 'required',
			];
			
			$message = [
				'credential_key.required' => 'Kunci Rahasia wajib diisi'	
			];
			
			Validator::validate($request->all(), $rules, $message);
		}
		
		$signatureModel = SignatureModel::where('employee_id', $model->from_employee_id)->first();
		
		if (!empty($signatureModel)) {
			Upload::download($signatureModel->path_to_file);
			$generate = DigitalSign::generate_ca($signatureModel, $request);
			
			if (!$generate) {
				return ['message' => config('constans.error.generate'), 'status' => false];
			}
		}
		
		if ($request->signature_available == 'true' && !empty($signatureModel)) {
			$document = Smartdoc::outgoing_mail_signature($model);
		}else{
			$document = Smartdoc::outgoing_mail($model);
		}
		
		$model->update([
			'signed' => !$request->signature_available ? false : true,
			'status' => OutgoingMailStatusConstants::SIGNED,
			'path_to_file' => $document,
		]);
		
		/* Send Email to Publisher */
		$email = publisher_email();
		$const_email = EmailConstants::PRE_PUBLISH;
		$data_email = [
			'button' => true,
			'email' => !empty($email) ? $email : NULL,
			'url' => setting_by_code('URL_PRE_PUBLISH_OUTGOING_MAIL'). '?type=OM&skey='. Crypt::encrypt($id)
		];
		
		$this->send_email($model, $data_email, $const_email);
		
		$this->send_notification([
			'model' => $model, 
			'heading' => MailCategoryConstants::SURAT_KELUAR,
			'title' => 'pre-publish',
			'redirect_web' => setting_by_code('URL_PRE_PUBLISH_OUTGOING_MAIL'),
			'redirect_mobile' => '',
			'receiver' => $email
		]);
		
		signed_log($model);
		
		return [
			'message' => config('constans.success.signed'), 
			'status' => true
		];
	}
	
	private function send_email($model, $data, $email_action)
	{
		$body = body_email($model, setting_name_by_code('SURAT_KELUAR'), $email_action);
		
		if (empty($data['email'])) {
			return FALSE;
		}
		
		foreach ($data['email'] as $ds) {
			dispatch(new SendEmailReminderJob([
				'name' => '',
				'button' => true,
				'email' => $ds['email'],
				'url' => $data['url'],
				'body' => $body,
				'notification_action' => config('constans.notif-email.'. $email_action),
			]));
		}
	}
	
	private function send_notification($notif)
	{
		if (empty($notif['receiver'])) {
			return false;
		}
		foreach ($notif['receiver'] as $ns) {
			event(new Notif([
				'heading' => $notif['heading'],
				'title'  => $notif['title'],
				'subject' => $notif['model']->subject_letter,
				'data' => serialize([
					'id' => $notif['model']->id,
					'subject_letter' => $notif['model']->subject_letter
				]),
				'redirect_web' => $notif['redirect_web'],
				'redirect_mobile' => $notif['redirect_mobile'],
				'type' => source_type("OM", $notif['model']),
				'receiver_id' => $ns['employee_id']
			]));
		}
	}
}
