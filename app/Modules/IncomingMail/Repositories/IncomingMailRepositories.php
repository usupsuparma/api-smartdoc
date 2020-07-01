<?php namespace App\Modules\IncomingMail\Repositories;
/**
 * Class IncomingMailRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\IncomingMail\Interfaces\IncomingMailInterface;
use App\Modules\IncomingMail\Models\IncomingMailModel;
use App\Modules\IncomingMail\Transformers\IncomingMailTransformer;
use App\Modules\IncomingMail\Models\IncomingMailAttachment;
use App\Modules\IncomingMail\Models\IncomingMailFollowUp;
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use App\Events\Notif;
use App\Constants\MailCategoryConstants;
use App\Constants\EmailInConstants;
use App\Jobs\SendEmailReminderJob;
use Validator, DB, Auth;
use Upload;

class IncomingMailRepositories extends BaseRepository implements IncomingMailInterface
{
	protected $parents;
	
	public function model()
	{
		return IncomingMailModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->authorityData();
		
		if ($request->has('keyword') && !empty($request->keyword)) {
			$query->where('subject_letter', 'like', "%{$request->keyword}%");
			$query->orWhere('number_letter', 'like', "%{$request->keyword}%");
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
		$data =  $this->model->findOrFail($id);
		
		return ['data' => IncomingMailTransformer::customTransform($data)];
	}
	
	public function create($request)
    {
		$rules = [
			'subject_letter' => 'required',
			'number_letter' => 'required',
			'type_id' => 'required',
			'classification_id' => 'required',
			'letter_date' => 'required',
			'recieved_date' => 'required',
			'sender_name' => 'required',
			'receiver_name' => 'required',
			'to_employee_id' => 'required',
			'structure_id' => 'required',
			'retension_date' => 'required',
			'file' => 'required|mimes:pdf,xlsx,xls,doc,docx|max:2048',
		];
		
		$message = [
			'subject_letter.required' => 'perihal surat wajib diisi',
			'number_letter.required' => 'nomor surat wajib diisi',
			'type_id.required' => 'jenis surat wajib diisi',
			'classification_id.required' => 'klasifikasi surat wajib diisi',
			'letter_date.required' => 'tanggal surat wajib diisi',
			'recieved_letter.required' => 'tanggal diterima surat wajib diisi',
			'sender_name.required' => 'pengirim surat wajib diisi',
			'receiver_name.required' => 'penerima surat wajib diisi',
			'to_employee_id.required' => 'pegawai wajib diisi',
			'structure_id.required' => 'struktur wajib diisi',
			'retension_date.required' => 'tanggal retensi wajib diisi',
			'file.required' => 'file wajib diisi',
			'file.mimes' => 'file harus berupa berkas berjenis: pdf, xlsx, xls, doc, docx.',
		];
		
		if (isset($request->attachments)) {
			foreach ($request->attachments as $key => $attachment) {
				$rules['attachments.'.$key.'.attachment_name'] = ['required'];
				$rules['attachments.'.$key.'.file'] = [
					'required',
					'mimes:pdf,xlsx,xls,doc,docx',
					'max:2048'
				];
				
				$message['attachments.'.$key.'.attachment_name.required'] = 'Nama File '.$key. ' wajib diisi';
				$message['attachments.'.$key.'.file.required'] = 'File '.$key. ' wajib diisi';
				$message['attachments.'.$key.'.file.mimes'] = 'File '.$key. ' harus berupa berkas berjenis: pdf, xlsx, xls, doc, docx.';
			}
		} 
		
		Validator::validate($request->all(), $rules, $message);
		
		DB::beginTransaction();

        try {
			$model = $this->model->create($request->all());

			if (isset($request->attachments)) {
				foreach ($request->attachments as $k => $attach) {
					$upload = Upload::uploads(setting_by_code('PATH_DIGITAL_INCOMING_MAIL'), $attach['file']);
					
					$model->attachments()->create([
						'attachment_name' => $attach['attachment_name'],
						'attachment_order' => $k + 1,
						'path_to_file' => !empty($upload) ? $upload : null
					]);
				}
			}
			
			$upload_main = Upload::uploads(setting_by_code('PATH_DIGITAL_INCOMING_MAIL'), $request->file);
			
			$model->update([
				'status' => false,
				'path_to_file' => !empty($upload_main) ? $upload_main : null
			]);
			
			if ($request->button_action == IncomingMailStatusConstans::SEND) {
				$model->update([
					'status' => IncomingMailStatusConstans::SEND
				]);
				
				$this->send_email($model);
				
				$this->send_notification([
					'model' => $model, 
					'heading' => MailCategoryConstants::SURAT_MASUK,
					'title' => 'follow-up-incoming', 
					'receiver' => $model->to_employee_id
				]);
				
				push_notif([
					'device_id' => find_device_mobile($model->to_employee_id),
					'data' => ['route_name' => 'IncomingMail'],
					'heading' => '[SURAT MASUK]',
					'content' => "Incoming Mail - {$model->subject_letter} memerlukan tindak lanjut anda. "
				]);
			}
	
            DB::commit();
        } catch (\Exception $ex) {
			DB::rollback();
            return ['message' => $ex->getMessage(), 'status' => false];
		}

		created_log($model);
		
		return [
			'message' => config('constans.success.created'),
			'status' => true
		];
		
	}
	
	public function update($request, $id)
    {
		$model = $this->model->findOrFail($id);
		
		$rules = [
			'subject_letter' => 'required',
			'number_letter' => 'required',
			'type_id' => 'required',
			'classification_id' => 'required',
			'letter_date' => 'required',
			'recieved_date' => 'required',
			'sender_name' => 'required',
			'receiver_name' => 'required',
			'to_employee_id' => 'required',
			'structure_id' => 'required',
			'retension_date' => 'required'
		];
		
		$message = [
			'subject_letter.required' => 'perihal surat wajib diisi',
			'number_letter.required' => 'nomor surat wajib diisi',
			'type_id.required' => 'jenis surat wajib diisi',
			'classification_id.required' => 'klasifikasi surat wajib diisi',
			'letter_date.required' => 'tanggal surat wajib diisi',
			'recieved_letter.required' => 'tanggal diterima surat wajib diisi',
			'sender_name.required' => 'pengirim surat wajib diisi',
			'receiver_name.required' => 'penerima surat wajib diisi',
			'to_employee_id.required' => 'pegawai wajib diisi',
			'structure_id.required' => 'struktur wajib diisi',
			'retension_date.required' => 'tanggal retensi wajib diisi'
		];
		
		if ($request->hasFile('file')) {
			$rules['file'] = ['mimes:pdf,xlsx,xls,doc,docx|max:2048'];
			$message['file.mimes'] = 'file harus berupa berkas berjenis: pdf, xlsx, xls, doc, docx.';
		}
		
		Validator::validate($request->all(), $rules, $message);
		
		DB::beginTransaction();

        try {
			
			$upload_main = $model->path_to_file;
		
			if ($request->hasFile('file')) {
				Upload::delete($upload_main);
				$upload_main = Upload::uploads(setting_by_code('PATH_DIGITAL_INCOMING_MAIL'), $request->file);
			}
			
			if (isset($request->attachments)) {
				foreach ($request->attachments as $k => $attach) {
					$upload = Upload::uploads(setting_by_code('PATH_DIGITAL_INCOMING_MAIL'), $attach['file']);
					
					$model->attachments()->create([
						'attachment_name' => $attach['attachment_name'],
						'attachment_order' => $k + 1,
						'path_to_file' => !empty($upload) ? $upload : null
					]);
				}
			}
		
			$model->update($request->merge([
				'path_to_file' => !empty($upload_main) ? $upload_main : null
			])->all());
			
			if ($request->button_action == IncomingMailStatusConstans::SEND) {
				$model->update([
					'status' => IncomingMailStatusConstans::SEND
				]);
				
				$this->send_email($model);
				
				$this->send_notification([
					'model' => $model, 
					'heading' => MailCategoryConstants::SURAT_MASUK,
					'title' => 'follow-up-incoming', 
					'receiver' => $model->to_employee_id
				]);
				
				push_notif([
					'device_id' => find_device_mobile($model->to_employee_id),
					'data' => ['route_name' => 'IncomingMail'],
					'heading' => '[SURAT MASUK]',
					'content' => "Incoming Mail - {$model->subject_letter} memerlukan tindak lanjut anda. "
				]);
			}
			
            DB::commit();
        } catch (\Exception $ex) {
			DB::rollback();
			return ['message' => $ex->getMessage(), 'status' => false];
		}

		updated_log($model);
		
		return [
			'message' => config('constans.success.updated'),
			'status' => true
		];
	}
	
	public function delete($id)
    {
		$model = $this->model->findOrFail($id);
		deleted_log($model);
		$model->delete();
		
		return ['message' => config('constans.success.deleted')];
	}
	
	public function delete_attachment($attachment_id)
    {
		$model = IncomingMailAttachment::findOrFail($attachment_id);
		$model->delete();
		
		return ['message' => config('constans.success.deleted')];
	}
	
	public function download_attachment($attachment_id)
    {
		$model = IncomingMailAttachment::findOrFail($attachment_id);
		Upload::download($model->path_to_file);
		
		return $model->path_to_file;
	}
	
	public function download_attachment_main($id)
    {
		$model = $this->model->findOrFail($id);
		Upload::download($model->path_to_file);
		
		return $model->path_to_file;
	}
	
	private function send_email($model)
	{
		$body = body_email_in($model, setting_name_by_code('SURAT_MASUK'), EmailInConstants::SEND);
		$email = smartdoc_user($model->to_employee->user->user_id);
		$data = [
			'email' => !empty($email) ? $email->email : NULL,
			'name'  => $model->to_employee->name,
			'notification_action' => config('constans.notif-email-in.'. EmailInConstants::SEND),
			'body' => $body,
			'button' => true,
			'url' => setting_by_code('URL_SEND_INCOMING_MAIL')
		];
		
		dispatch(new SendEmailReminderJob($data));
	}
	
	public function follow_up($request, $id)
	{		
		$model = $this->model->followUpEmployee()->firstOrFail();
		
		$rules = [
			'description' => 'required'
		];
		
		$message = [
			'description.required' => 'catatan tindak lanjut wajib diisi'
		];
		
		if ($request->hasFile('file')) {
			$rules['file'] = ['mimes:pdf,xlsx,xls,doc,docx|max:2048'];
			$message['file.mimes'] = 'file harus berupa berkas berjenis: pdf, xlsx, xls, doc, docx.';
		}
		
		Validator::validate($request->all(), $rules, $message);
		
		$upload = null;
		
		if ($request->hasFile('file')) {
			$upload = Upload::uploads(setting_by_code('PATH_DIGITAL_INCOMING_MAIL'), $request->file);
		}
		
		$model->update([
			'status' => IncomingMailStatusConstans::DONE
		]);
		
		$model->follow_ups()->create([
			'employee_id' => Auth::user()->user_core->id_employee,
			'description' => $request->description,
			'path_to_file' => !empty($upload) ? $upload : null
		]);
		
		return ['message' => config('constans.success.follow-up')];
	}
	
	public function options()
	{
		return ['data' => $this->model->options()];
	}
	
	private function send_notification($notif)
	{
		$data_notif = [
			'heading' => $notif['heading'],
			'title'  => $notif['title'],
			'subject' => $notif['model']->subject_letter,
			'data' => serialize([
				'id' => $notif['model']->id,
				'subject_letter' => $notif['model']->subject_letter
			]),
			'redirect_web' => setting_by_code('URL_INCOMING_MAIL'),
			'redirect_mobile' => serialize([
				'route_name' => 'IncomingMail',
			]),
			'receiver_id' => $notif['receiver']
		];
		
		event(new Notif($data_notif));
	}
}
