<?php namespace App\Modules\OutgoingMail\Repositories;
/**
 * Class ApprovalOutgoingMailRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Crypt;
use App\Modules\OutgoingMail\Interfaces\ApprovalOutgoingMailInterface;
use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use App\Modules\OutgoingMail\Transformers\OutgoingMailTransformer;
use App\Modules\OutgoingMail\Models\OutgoingMailApproval;
use App\Constants\StatusApprovalConstants;
use App\Modules\OutgoingMail\Constans\OutgoingMailStatusConstants;
use App\Constants\EmailConstants;
use App\Jobs\SendEmailReminderJob;
use App\Events\Notif;
use App\Constants\MailCategoryConstants;
use Validator, DB, Auth, Upload, Smartdoc;

class ApprovalOutgoingMailRepositories extends BaseRepository implements ApprovalOutgoingMailInterface
{
	protected $parents;
	
	public function model()
	{
		return OutgoingMailModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->byEmployeId();
		
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
		$data =  $this->model->byEmployeId()->where('id', $id)->firstOrFail();
		
		return ['data' => OutgoingMailTransformer::customTransform($data)];
	}
	
	public function update($request, $id)
    {
		$model = $this->model->byEmployeId()->where('id', $id)->firstOrFail();
		
		$modelApproval = OutgoingMailApproval::where([
			'outgoing_mail_id' => $id,
			'employee_id' => Auth::user()->user_core->employee->id_employee,
			'structure_id' => Auth::user()->user_core->structure->id,
			'status' => true
		])->firstOrFail();
		
		$rules = [
			'status_approval' => 'required',
		];
		
		$message = [
			'status_approval.required' => 'Status Approval wajib diisi',
		]; 
		
		if ($request->hasFile('file')) {
			$rules['file'] = ['mimes:pdf,jpg,jpeg,png|max:4096'];
			$message['file.mimes'] = 'file harus berupa berkas berjenis: pdf, jpg, jpeg, png.';
		}
		
		Validator::validate($request->all(), $rules, $message);
		
		$upload = null;
		
		$nextApprovalEmployee = NULL;
		$nextApprovalStructure = NULL;
		
		$nextApproval = $this->next_approval($id);
		
		if (!empty($nextApproval)) {
			$nextApprovalEmployee = !empty($nextApproval->employee) ? $nextApproval->employee->id_employee : '';
			$nextApprovalStructure = !empty($nextApproval->employee->user) ? $nextApproval->employee->user->structure->id : '';
		}
		
		DB::beginTransaction();
		
        try {
			
			if ($request->hasFile('file')) {
				$upload = Upload::uploads(setting_by_code('PATH_DIGITAL_OUTGOING_MAIL'), $request->file);
			}
			
			if ((int) $request->status_approval === StatusApprovalConstants::APPROVED) {
				if (!empty($nextApproval)) {
					$data = [
						'current_approval_employee_id' => $nextApprovalEmployee,
						'current_approval_structure_id' => $nextApprovalStructure,
					];
					
					$title = 'approval';
					$receiver_id = $nextApprovalEmployee;
					$redirect_web = setting_by_code('URL_APPROVAL_OUTGOING_MAIL');
					$redirect_mobile = serialize(['route_name' => 'Approval']);
					
					/* Send Email  next approval */
					$email = smartdoc_user($nextApprovalEmployee);
					$const_email = EmailConstants::APPROVED;
					$data_email = [
						'name'  => $email->user_core->employee->name,
						'button' => true,
						'email' => !empty($email) ? $email->email : NULL,
						'url' => $redirect_web. '?type=OM&skey='. Crypt::encrypt($id)
					];
					
					push_notif([
						'device_id' => find_device_mobile($nextApprovalEmployee),
						'data' => ['route_name' => 'Approval'],
						'heading' => '[SURAT KELUAR]',
						'content' => "Approval - {$model->subject_letter} memerlukan persetujuan anda. "
					]);
					
				} else {
					$data = [
						'current_approval_employee_id' => NULL,
						'current_approval_structure_id' => NULL,
						'status' => OutgoingMailStatusConstants::APPROVED
					];
					
					$title = 'signed';
					$receiver_id = $model->from_employee_id;
					$redirect_web = setting_by_code('URL_SIGNED_OUTGOING_MAIL');
					$redirect_mobile = serialize(['route_name' => 'Signed']);
					
					/* Send Email to Signed */
					$email = smartdoc_user($model->from_employee->user->user_id);
					$const_email = EmailConstants::SIGNED;
					$data_email = [
						'name'  => $model->from_employee->name,
						'button' => true,
						'email' => !empty($email) ? $email->email : NULL,
						'url' => $redirect_web. '?type=OM&skey='. Crypt::encrypt($id)
					];
					
					push_notif([
						'device_id' => find_device_mobile($model->from_employee_id),
						'data' => ['route_name' => 'Signed'],
						'heading' => '[SURAT KELUAR]',
						'content' => "Signed - {$model->subject_letter} memerlukan tanda tangan anda. "
					]);
				}
				
				$this->send_email($model, $data_email, $const_email);
				
				$this->send_notification([
					'model' => $model, 
					'heading' => MailCategoryConstants::SURAT_KELUAR,
					'title' => $title,
					'redirect_web' => $redirect_web,
					'redirect_mobile' => $redirect_mobile,
					'receiver' => $receiver_id
				]);
				
				approve_log($model);
				
			} else {
				$data = [
					'current_approval_employee_id' => NULL,
					'current_approval_structure_id' => NULL,
					'status' => OutgoingMailStatusConstants::DRAFT
				];
				
				foreach ($model->approvals as $appro) {
					$appro->update(['status' => false]);
				}
				
				/* Send Email to Draft */
				$email = smartdoc_user($model->created_by->user->user_id);
				$const_email = EmailConstants::REJECT;
				$data_email = [
					'name'  => $model->created_by->name,
					'button' => true,
					'email' => !empty($email) ? $email->email : NULL,
					'url' => setting_by_code('URL_OUTGOING_MAIL'). '?type=OM&skey='. Crypt::encrypt($id)
				];
				
				$this->send_email($model, $data_email, $const_email);
				
				$this->send_notification([
					'model' => $model, 
					'heading' => MailCategoryConstants::SURAT_KELUAR,
					'title' => 'reject',
					'redirect_web' => setting_by_code('URL_OUTGOING_MAIL'),
					'redirect_mobile' => '',
					'receiver' => $model->created_by_employee
				]);
				
				reject_log($model);
			}
		
			$modelApproval->update($request->merge([
				'path_to_file' => !empty($upload) ? $upload : null
			])->all());
			 
			$model->update($data);
			
            DB::commit();
        } catch (\Exception $ex) {
			DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
			
			return ['message' => config('constans.error.approve')];
		}
		
		$message = config('constans.success.reject');
		
		if ((int) $request->status_approval === StatusApprovalConstants::APPROVED) {
			$message = config('constans.success.approve');
		}
		
		return [
			'message' => $message,
			'status' => true
		];
	}
	
	private function next_approval($outgoing_mail_id)
	{
		$collection = OutgoingMailApproval::nextApproval($outgoing_mail_id);

		$filtered = $collection->filter(function ($value, $key){
			return $value->employee_id !== Auth::user()->user_core->employee->id_employee;
		});

		return $filtered->first();
	}
	
	private function send_email($model, $data, $email_action)
	{
		$body = body_email($model, setting_name_by_code('SURAT_KELUAR'), $email_action);
		$data['body'] = $body;
		$data['notification_action'] = config('constans.notif-email.'. $email_action);
		
		dispatch(new SendEmailReminderJob($data));
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
			'redirect_web' => $notif['redirect_web'],
			'redirect_mobile' => $notif['redirect_mobile'],
			'type' => source_type("OM", $notif['model']),
			'receiver_id' => $notif['receiver']
		];
		
		event(new Notif($data_notif));
	}
	
	public function download_attachment_approval($approval_id)
    {
		$model = OutgoingMailApproval::findOrFail($approval_id);
		Upload::download($model->path_to_file);
		
		return $model->path_to_file;
	}
	
	public function download_review_outgoing_mail($id)
    {
		$model = $this->model->findOrFail($id);
		$document = Smartdoc::outgoing_mail($model, []);
		
		return $document;
	}
}

