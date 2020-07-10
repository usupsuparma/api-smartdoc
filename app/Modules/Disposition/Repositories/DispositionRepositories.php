<?php namespace App\Modules\Disposition\Repositories;
/**
 * Class DispositionRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Disposition\Interfaces\DispositionInterface;
use App\Modules\Disposition\Models\DispositionModel;
use App\Modules\Disposition\Transformers\DispositionTransformer;
use App\Modules\Disposition\Models\DispositionAssign;
use App\Modules\Disposition\Models\DispositionFollowUp;
use App\Modules\Signature\Models\SignatureModel;
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use App\Modules\IncomingMail\Models\IncomingMailModel;
use App\Constants\EmailInConstants;
use App\Jobs\SendEmailReminderJob;
use Illuminate\Support\Facades\Crypt;
use App\Events\Notif;
use App\Constants\MailCategoryConstants;
use Validator, DB, Auth;
use Upload, DigitalSign, Smartdoc;
use Carbon\Carbon;

class DispositionRepositories extends BaseRepository implements DispositionInterface
{
	protected $parents;
	
	public function model()
	{
		return DispositionModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->authorityData();
		
		if ($request->has('keyword') && !empty($request->keyword)) {
			$query->where('subject_disposition', 'like', "%{$request->keyword}%");
			$query->orWhere('number_disposition', 'like', "%{$request->keyword}%");
		}
		
		if ($request->has('start_date') &&  $request->has('end_date')) {
			if (!empty($request->start_date) && !empty($request->end_date)) {
				$query->whereBetween('disposition_date', [$request->start_date, $request->end_date]);	
			}
		}
		
		if ($request->has('status')) {
			if (!empty($request->status)) {
				$query->where('status', $request->status);	
			}
		}

		return $query->get();
	}
	
	public function show($id)
    {
		$data =  $this->model->findOrFail($id);
		
		return ['data' => DispositionTransformer::customTransform($data)];
	}
	
	public function create($request)
    {
		$signatureModel = SignatureModel::checkAvailableSignature()->first();
		
		$rules = [
			'incoming_mail_id' => 'required',
			'subject_disposition' => 'required',
			'description' => 'required',
		];
		
		$message = [
			'incoming_mail_id.required' => 'surat masuk wajib diisi',
			'subject_disposition.required' => 'perihal disposisi wajib diisi',
			'description.required' => 'keterangan surat disposisi wajib diisi',
		];
		
		if ($request->button_action == IncomingMailStatusConstans::SEND && !empty($signatureModel)) {
			$rules['credential_key'] = ['required'];
			$message['credential_key.required'] = 'Kunci Rahasia wajib diisi';
			
		}
		
		if (isset($request->assigns)) {
			foreach ($request->assigns as $key => $assign) {
				$rules['assigns.'.$key.'.structure_id'] = ['required'];
				$rules['assigns.'.$key.'.employee_id'] = ['required'];
				$rules['assigns.'.$key.'.classification_disposition_id'] = ['required'];
				
				$message['assigns.'.$key.'.structure_id.required'] = 'Divisi '.$key. ' wajib diisi';
				$message['assigns.'.$key.'.employee_id.required'] = 'Pegawai '.$key. ' wajib diisi';
				$message['assigns.'.$key.'.classification_disposition_id.required'] = 'Klasifikasi Disposisi '.$key. ' wajib diisi';
			}
		} else {
			return [
				'message' => 'Tujuan surat disposisi ini tidak boleh kosong !',
				'status' => false
			];	
		}
		
		Validator::validate($request->all(), $rules, $message);
			
		if (!empty($signatureModel)) {
			if ($request->button_action == IncomingMailStatusConstans::SEND) {
				Upload::download($signatureModel->path_to_file);
				$generate = DigitalSign::generate_ca($signatureModel, $request);
				
				if (!$generate) {
					return ['message' => config('constans.error.generate'), 'status' => false];
				}
			}
		}

		$structure_code_user = Auth::user()->user_core->structure->kode_struktur;
		
		DB::beginTransaction();

        try {
			
			$model = $this->model->create($request->merge([
				'status' => IncomingMailStatusConstans::DRAFT,
				'from_employee_id' => Auth::user()->user_core->id_employee,
				'disposition_date' => Carbon::now()->format('Y-m-d')
			])->all());

			if (isset($request->assigns)) {
				foreach ($request->assigns as $k => $assign) {
					$model->assign()->create([
						'structure_id' => $assign['structure_id'],
						'employee_id' => $assign['employee_id'],
						'classification_disposition_id' => $assign['classification_disposition_id']
					]);
				}
			}
			
			if ($request->button_action == IncomingMailStatusConstans::SEND) {
				
				$data_qr = [
					'type' => setting_by_code('DISPOSISI'),
					'url' => setting_by_code('URL_VERIFY_OUTGOING_MAIL'). '?type=DISPO&skey='. Crypt::encrypt($model->id)
				];
				
				/* Generate temp qr code */
				$createQR = Upload::create_qr_code($data_qr);
				
				$qr_code = [
					'image_qr' => $createQR
				];
				
				$model->update([
					'number_disposition' => Smartdoc::render_code_disposition($structure_code_user),
				]);
				
				$document = Smartdoc::disposition_mail($model, $qr_code);
				
				/* Upload document local data to FTP */
				Upload::upload_local_to_ftp($document);
				
				/* Remove document local */
				Upload::delete_local($document);
				
				/* Remove temp qr code */
				Upload::delete_local($createQR);
				
				/* Remove certificate */
				if (!empty($signatureModel)) {
					if (empty($signatureModel->credential_key)) {
						// DigitalSign::delete_ca($model->signature);
					}
				}
				
				$model->update([
					'status' => IncomingMailStatusConstans::DISPOSITION,
					'path_to_file' => $document,
					'disposition_date' => Carbon::now()->format('Y-m-d')
				]);
				
				if (isset($model->assign)) {
					foreach ($model->assign as $assign) {
						/* All Notification */
						$this->send_email($model, $assign);
						
						$this->send_notification([
							'model' => $model, 
							'heading' => MailCategoryConstants::SURAT_DISPOSISI,
							'title' => 'follow-up-disposition', 
							'receiver' => $assign['employee_id']
						]);
						
						push_notif([
							'device_id' => find_device_mobile($assign['employee_id']),
							'data' => ['route_name' => 'DispositionFollowUp'],
							'heading' => '[SURAT DISPOSISI]',
							'content' => "Disposition Follow Up - {$model->subject_disposition} memerlukan tindak lanjut anda. "
						]);
					}
				}
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
		$signatureModel = SignatureModel::checkAvailableSignature()->first();
		
		$rules = [
			'incoming_mail_id' => 'required',
			'subject_disposition' => 'required',
			'description' => 'required',
		];
		
		$message = [
			'incoming_mail_id.required' => 'surat masuk wajib diisi',
			'subject_disposition.required' => 'perihal disposisi wajib diisi',
			'description.required' => 'keterangan surat disposisi wajib diisi',
		];
		
		if ($request->button_action == IncomingMailStatusConstans::SEND && !empty($signatureModel)) {
			$rules['credential_key'] = ['required'];
			$message['credential_key.required'] = 'Kunci Rahasia wajib diisi';
			
		}
		
		if (isset($request->assigns)) {
			foreach ($request->assigns as $key => $assign) {
				$rules['assigns.'.$key.'.structure_id'] = ['required'];
				$rules['assigns.'.$key.'.employee_id'] = ['required'];
				$rules['assigns.'.$key.'.classification_disposition_id'] = ['required'];
				
				$message['assigns.'.$key.'.structure_id.required'] = 'Struktur '.$key. ' wajib diisi';
				$message['assigns.'.$key.'.employee_id.required'] = 'Pegwawai '.$key. ' wajib diisi';
				$message['assigns.'.$key.'.classification_disposition_id.required'] = 'Klasifikasi Disposisi '.$key. ' wajib diisi';
			}
		} else {
			return [
				'message' => 'Tujuan surat disposisi ini tidak boleh kosong !',
				'status' => false
			];	
		}
		
		Validator::validate($request->all(), $rules, $message);
				
		if (!empty($signatureModel)) {
			if ($request->button_action == IncomingMailStatusConstans::SEND) {
				Upload::download($signatureModel->path_to_file);
				$generate = DigitalSign::generate_ca($signatureModel, $request);
				
				if (!$generate) {
					return ['message' => config('constans.error.generate'), 'status' => false];
				}
			}
		}

		$structure_code_user = Auth::user()->user_core->structure->kode_struktur;
		
		DB::beginTransaction();

        try {
			
			if (isset($request->assigns)) {
				$this->update_assign($model, $request->assigns);
			}
		
			if ($request->button_action == IncomingMailStatusConstans::SEND) {
				
				$data_qr = [
					'type' => setting_by_code('DISPOSISI'),
					'url' => setting_by_code('URL_VERIFY_OUTGOING_MAIL'). '?type=DISPO&skey='. Crypt::encrypt($model->id)
				];
				
				/* Generate temp qr code */
				$createQR = Upload::create_qr_code($data_qr);
				
				$qr_code = [
					'image_qr' => $createQR
				];
				if (empty($model->number_disposition)) {
					$model->update([
						'number_disposition' => Smartdoc::render_code_disposition($structure_code_user),
					]);
				}
				
				$document = Smartdoc::disposition_mail($model, $qr_code);
				/* Upload document local data to FTP */
				Upload::upload_local_to_ftp($document);
				
				/* Remove document local */
				Upload::delete_local($document);
				
				/* Remove temp qr code */
				Upload::delete_local($createQR);
				
				/* Remove certificate */
				if (!empty($signatureModel)) {
					if (empty($signatureModel->credential_key)) {
						// DigitalSign::delete_ca($model->signature);
					}
				}
				
				$model->update($request->merge([
					'status' => IncomingMailStatusConstans::DISPOSITION,
					'path_to_file' => $document,
					'disposition_date' => Carbon::now()->format('Y-m-d')
				])->all());
				
				if (isset($model->assign)) {
					foreach ($model->assign as $assign) {
						/* All Notification */
						$this->send_email($model, $assign);
						
						$this->send_notification([
							'model' => $model, 
							'heading' => MailCategoryConstants::SURAT_DISPOSISI,
							'title' => 'follow-up-disposition', 
							'receiver' => $assign['employee_id']
						]);
						
						push_notif([
							'device_id' => find_device_mobile($assign['employee_id']),
							'data' => ['route_name' => 'DispositionFollowUp'],
							'heading' => '[SURAT DISPOSISI]',
							'content' => "Disposition Follow Up - {$model->subject_disposition} memerlukan tindak lanjut anda. "
						]);
					}
				}				
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
	
	private function update_assign($model, $dataAssign) 
	{
		$ids = [];
		
		foreach ($dataAssign as $assign) {
			$datas = [
				'disposition_id' => $model->id,
				'employee_id' => $assign['employee_id'],
				'structure_id' => $assign['structure_id']
			];

			$check_assign = DispositionAssign::where($datas)->first();

			if (!empty($check_assign)) {
				$q = DispositionAssign::where('id', $check_assign->id)->update(
					array_merge($datas, ['classification_disposition_id' => $assign['classification_disposition_id']])
				);
				$ids[] = $check_assign->id;
			}else{
				$q = DispositionAssign::create(
					array_merge($datas, ['classification_disposition_id' => $assign['classification_disposition_id']])
				);
				$ids[] = $q->id;
			}
		}
		
		DispositionAssign::where('disposition_id', $model->id)
			->whereNotIn('id', $ids)
			->delete();
	}
	
	public function delete($id)
    {
		$model = $this->model->findOrFail($id);
		deleted_log($model);
		$model->delete();
		
		return ['message' => config('constans.success.deleted')];
	}
	
	public function download_main($id)
    {
		$model = $this->model->findOrFail($id);
		Upload::download($model->path_to_file);
		
		return $model->path_to_file;
	}
	
	public function download_incoming($incoming_mail_id)
    {
		$model = IncomingMailModel::findOrFail($incoming_mail_id);
		Upload::download($model->path_to_file);
		
		return $model->path_to_file;
	}
	
	public function download_follow($follow_id)
    {
		$model = DispositionFollowUp::findOrFail($follow_id);
		Upload::download($model->path_to_file);
		
		return $model->path_to_file;
	}
	
	private function send_email($model, $assign)
	{
		$body = body_email_in($model, setting_name_by_code('DISPOSISI'), EmailInConstants::SEND);
		$email = smartdoc_user($assign->employee->user->user_id);
		$data = [
			'email' => !empty($email) ? $email->email : NULL,
			'name'  => $assign->employee->name,
			'notification_action' => config('constans.notif-email-in.'. EmailInConstants::SEND),
			'body' => $body,
			'button' => true,
			'url' => setting_by_code('URL_DISPOSITION_FOLLOW')
		];
		
		dispatch(new SendEmailReminderJob($data));
	}
	
	private function send_notification($notif)
	{
		$data_notif = [
			'heading' => $notif['heading'],
			'title'  => $notif['title'],
			'subject' => $notif['model']->number_disposition,
			'data' => serialize([
				'id' => $notif['model']->id,
				'subject_disposition' => $notif['model']->subject_disposition,
				'number_disposition' => $notif['model']->number_disposition
			]),
			'redirect_web' => setting_by_code('URL_DISPOSITION_FOLLOW'),
			'redirect_mobile' => serialize([
				'route_name' => 'DispositionFollowUp',
			]),
			'receiver_id' => $notif['receiver']
		];
		
		event(new Notif($data_notif));
	}
}
