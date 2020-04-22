<?php namespace App\Modules\OutgoingMail\Repositories;
/**
 * Class AdminOutgoingMailRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Constants\EmailConstants;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\OutgoingMail\Interfaces\AdminOutgoingMailInterface;
use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use App\Modules\OutgoingMail\Transformers\OutgoingMailTransformer;
use App\Modules\OutgoingMail\Constans\OutgoingMailStatusConstants;
use Illuminate\Support\Facades\Crypt;
use App\Jobs\SendEmailReminderJob;
use Upload, DigitalSign, Smartdoc;
use Validator, Auth;
use Carbon\Carbon;


class AdminOutgoingMailRepositories extends BaseRepository implements AdminOutgoingMailInterface
{	
	public function model()
	{
		return OutgoingMailModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->readyPublish();
		
		if ($request->has('keyword') && !empty($request->keyword)) {
			$query->where('subject_letter', 'like', "%{$request->keyword}%");
		}
		
		return $query->get();
	}
	
	public function show($id)
    {
		$data =  $this->model->readyPublish()->where('id', $id)->firstOrFail();
		
		return ['data' => OutgoingMailTransformer::customTransform($data)];
	}
	
	public function update($request, $id)
    {
		$model = $this->model->readyPublish()->where('id', $id)->firstOrFail();
		
		$rules = [
			'button_action' => 'required',
			'signature_available' => 'required',
		];
		
		$message = [
			'button_action.required' => 'Tidak ada aksi yang dipilih .'	,
			'signature_available' => 'Status digital signature tidak diketahui .'	
		];
		
		Validator::validate($request->all(), $rules, $message);

		if ($request->button_action == OutgoingMailStatusConstants::DRAFT){
			
			if ($request->signature_available) {
				DigitalSign::delete_ca($model->signature);
			}
			
			/* Remove File in local storage*/
			Upload::delete_local($model);
			
			$model->update([
				'signed' => NULL,
				'status' => OutgoingMailStatusConstants::DRAFT,
				'path_to_file' => NULL,
			]);
			
			/* Send Email to user create mail */
			$data_email = [
				'name'  => $model->created_by->name,
				'button' => true,
				'url' => setting_by_code('URL_OUTGOING_MAIL')
			];
			
			$this->send_email($model, $data_email, EmailConstants::REJECT);
			
			reject_log($model);
			
			return [
				'message' => config('constans.success.reject'), 
				'status' => true
			];
			
		} else {
			
			$data_qr = [
				'type' => setting_by_code('SURAT_KELUAR'),
				'url' => setting_by_code('URL_VERIFY_OUTGOING_MAIL'). '?type=OM&skey='. Crypt::encrypt($id)
			];
			
			/* Generate temp qr code */
			$createQR = Upload::create_qr_code($data_qr);
			
			$qr_code = [
				'image_qr' => $createQR
			];
			
			$model->update([
				'number_letter' => Smartdoc::render_code_outgoing($model)
			]);

			if ($request->signature_available == 'true') {
				$document = Smartdoc::outgoing_mail_signature($model, $qr_code);
			}else{
				$document = Smartdoc::outgoing_mail($model, $qr_code);
			}
			
			/* Upload document local data to FTP */
			Upload::upload_local_to_ftp($document);
			
			/* Remove document local */
			Upload::delete_local($document);
			
			/* Remove temp qr code */
			Upload::delete_local($createQR);
			
			/* Remove certificate */
			if ($request->signature_available == 'true') {
				DigitalSign::delete_ca($model->signature);
			}
			
			$model->update([
				'status' => OutgoingMailStatusConstants::PUBLISH,
				'path_to_file' => $document,
				'publish_by_employee' => Auth::user()->user_core->employee->id_employee,
				'publish_date' => Carbon::now(),
			]);
			
			/* Send Email to user create mail */
			$data_email = [
				'name'  => $model->created_by->name,
				'button' => true,
				'url' => setting_by_code('URL_VERIFY_OUTGOING_MAIL'). '?type=OM&skey='. Crypt::encrypt($id)
			];
			
			$this->send_email($model, $data_email, EmailConstants::PUBLISH);
			
			publish_log($model);
			
			return [
				'message' => config('constans.success.publish'), 
				'status' => true
			];
		}
	} 
	
	public function download($id)
    {
		$model = $this->model->findOrFail($id);
		
		if (!empty($model->subject_letter)) {
			Upload::download($model->path_to_file);
		}
		
		return $model->path_to_file;
	}
	
	private function send_email($model, $data, $email_action)
	{
		$body = body_email($model, setting_name_by_code('SURAT_KELUAR'), $email_action);
		$email = smartdoc_user($model->created_by->user->user_id);
		$data['email'] = !empty($email) ? $email->email : NULL;
		$data['body'] = $body;
		$data['notification_action'] = config('constans.notif-email.'. $email_action);
		
		dispatch(new SendEmailReminderJob($data));
	}
}