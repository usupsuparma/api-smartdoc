<?php namespace App\Modules\OutgoingMail\Repositories;
/**
 * Class ApprovalOutgoingMailRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
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
use Validator, DB, Auth;

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
			'description' => 'required',
		];
		
		$message = [
			'status_approval.required' => 'Status Approval wajib diisi',
			'description.required' => 'Catatan wajib diisi',
		]; 
		
		Validator::validate($request->all(), $rules, $message);
		
		$nextApprovalEmployee = NULL;
		$nextApprovalStructure = NULL;
		
		$nextApproval = $this->next_approval($id);
		
		if (!empty($nextApproval)) {
			$nextApprovalEmployee = !empty($nextApproval->employee) ? $nextApproval->employee->id_employee : '';
			$nextApprovalStructure = !empty($nextApproval->employee->user) ? $nextApproval->employee->user->structure->id : '';
		}
		
		DB::beginTransaction();
		
        try {
			
			if ((int) $request->status_approval === StatusApprovalConstants::APPROVED) {
				if (!empty($nextApproval)) {
					$data = [
						'current_approval_employee_id' => $nextApprovalEmployee,
						'current_approval_structure_id' => $nextApprovalStructure,
					];
					
					$title = 'approval';
					$receiver_id = $nextApprovalEmployee;
					
				} else {
					$data = [
						'current_approval_employee_id' => NULL,
						'current_approval_structure_id' => NULL,
						'status' => OutgoingMailStatusConstants::APPROVED
					];
					
					$title = 'signed';
					$receiver_id = $model->from_employee_id;
				}
				
				$this->send_notification([
					'model' => $model, 
					'heading' => MailCategoryConstants::SURAT_KELUAR,
					'title' => $title,
					'redirect_web' => setting_by_code('URL_APPROVAL_OUTGOING_MAIL'),
					'redirect_mobile' => '',
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
		
			$modelApproval->update($request->all());
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
			'receiver_id' => $notif['receiver']
		];
		
		event(new Notif($data_notif));
	}
}

