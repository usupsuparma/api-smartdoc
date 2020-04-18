<?php namespace App\Modules\OutgoingMail\Repositories;
/**
 * Class OutgoingMailRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\OutgoingMail\Interfaces\OutgoingMailInterface;
use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use App\Modules\OutgoingMail\Constans\OutgoingMailStatusConstants;
use App\Modules\OutgoingMail\Transformers\OutgoingMailTransformer;
use App\Modules\OutgoingMail\Models\OutgoingMailAttachment;
use App\Modules\External\Organization\Models\OrganizationModel;
use App\Modules\OutgoingMail\Models\OutgoingMailForward;
use App\Constants\EmailConstants;
use App\Jobs\SendEmailReminderJob;
use Validator, DB, Auth;
use Upload;

class OutgoingMailRepositories extends BaseRepository implements OutgoingMailInterface
{
	protected $parents;
	
	public function model()
	{
		return OutgoingMailModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->authorityData();
		
		if ($request->has('keyword') && !empty($request->keyword)) {
			$query->where('subject_letter', 'like', "%{$request->keyword}%");
		}
		
		return $query->get();
	}
	
	public function show($id)
    {
		$data =  $this->model->findOrFail($id);
		
		return ['data' => OutgoingMailTransformer::customTransform($data)];
	}
	
	public function create($request)
    {
		$rules = [
			'subject_letter' => 'required',
			'type_id' => 'required',
			'classification_id' => 'required',
			'letter_date' => 'required',
			'from_employee_id' => 'required',
			'retension_date' => 'required',
			'body' => 'required'
		];
		
		$message = [
			'subject_letter.required' => 'perihal surat wajib diisi',
			'type_id.required' => 'jenis surat wajib diisi',
			'classification_id.required' => 'klasifikasi surat wajib diisi',
			'from_employee_id.required' => 'pengirim surat wajib diisi',
			'letter_date.required' => 'tanggal surat wajib diisi',
			'retension_date.required' => 'tanggal retensi wajib diisi',
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
		
		if (isset($request->copy_of_letter)) {
			foreach ($request->copy_of_letter as $key => $col) {
				$rules['copy_of_letter.'.$key] = ['required'];
				$message['copy_of_letter.'.$key.'.required'] = 'Tembusan '.$key. ' wajib diisi';
			}
		} 
		
		Validator::validate($request->all(), $rules, $message);
		
		$hierarchy_orgs = $this->bottom_to_top($request);
		$check_director_level = $this->structure_from_employee($request);

		if ($request->button_action == OutgoingMailStatusConstants::SEND_TO_REVIEW)
		{
			if ($check_director_level) {
				/* check list review hierarchy director*/
				$reviews = review_list(setting_by_code('SURAT_KELUAR'));
			} else {
				$reviews = review_list_non_director($hierarchy_orgs);
			}

			if (!$reviews) {
				return [
					'message' => 'Tidak Terdapat User yang akan memeriksa surat ini. silahkan set terlebih dahulu !',
					'status' => false
				];	
			}
		}

		DB::beginTransaction();

        try {
			$model = $this->model->create($request->merge([
				'status' => OutgoingMailStatusConstants::DRAFT,
				'created_by_employee' => Auth::user()->user_core->id_employee,
				'created_by_structure' => Auth::user()->user_core->structure->id,
			])->all());
			
			if (isset($request->copy_of_letter)) {
				foreach ($request->copy_of_letter as $copy) {
					$model->forwards()->create(['employee_id' => $copy]);
				}
			}
			
			if (isset($request->attachments)) {
				foreach ($request->attachments as $k => $attach) {
					$upload = Upload::uploads(setting_by_code('PATH_DIGITAL_OUTGOING_MAIL'), $attach['file']);
					
					$model->attachments()->create([
						'attachment_name' => $attach['attachment_name'],
						'attachment_order' => $k + 1,
						'path_to_file' => !empty($upload) ? $upload : null
					]);
				}
			}
			
			if ($request->button_action == OutgoingMailStatusConstants::SEND_TO_REVIEW) {
				foreach ($reviews as $review) {
					$model->approvals()->create([
						'structure_id' => $review['structure_id'],
						'employee_id' => $review['employee_id'],
						'status' => true
					]);
				}
				
				$model->update([
					'current_approval_structure_id' => $reviews[0]['structure_id'],
					'status' => OutgoingMailStatusConstants::REVIEW,
				]);
			}
	
            DB::commit();
        } catch (\Exception $ex) {
			DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
			
			return ['message' => config('constans.error.created')];
		}

		created_log($model);
		
		return [
			'message' => config('constans.success.created'),
			'status' => true
		];
		
	}
	
	public function update($request, $id)
    {
		$rules = [
			'subject_letter' => 'required',
			'type_id' => 'required',
			'classification_id' => 'required',
			'letter_date' => 'required',
			'from_employee_id' => 'required',
			'body' => 'required'
		];
		
		$message = [
			'subject_letter.required' => 'perihal surat wajib diisi',
			'type_id.required' => 'jenis surat wajib diisi',
			'classification_id.required' => 'klasifikasi surat wajib diisi',
			'from_employee_id.required' => 'pengirim surat wajib diisi',
			'letter_date.required' => 'tanggal surat wajib diisi',
		];
		
		if (isset($request->copy_of_letter)) {
			foreach ($request->copy_of_letter as $key => $col) {
				$rules['copy_of_letter.'.$key] = ['required'];
				$message['copy_of_letter.'.$key.'.required'] = 'Tembusan '.$key. ' wajib diisi';
			}
		} 
		
		Validator::validate($request->all(), $rules, $message);
		
		$model = $this->model->findOrFail($id);
		
		$hierarchy_orgs = $this->bottom_to_top($request);
		$check_director_level = $this->structure_from_employee($request);

		if ($request->button_action == OutgoingMailStatusConstants::SEND_TO_REVIEW)
		{
			if ($check_director_level) {
				/* check list review hierarchy director*/
				$reviews = review_list(setting_by_code('SURAT_KELUAR'));
			} else {
				$reviews = review_list_non_director($hierarchy_orgs);
			}
			
			if (!$reviews) {
				return [
					'message' => 'Tidak Terdapat User yang akan memeriksa surat ini. silahkan set terlebih dahulu !',
					'status' => false
				];	
			}
		}
		
		
		DB::beginTransaction();

        try {	
			
			if (isset($request->copy_of_letter)) {
				OutgoingMailForward::where('outgoing_mail_id', $model->id)
					->whereNotIn('employee_id', $request->copy_of_letter)
					->delete();
					
				foreach ($request->copy_of_letter as $col) {
					$datas = [
						'outgoing_mail_id' => $id,
						'employee_id' => $col
					];

					$check_forwards = OutgoingMailForward::where($datas)->first();

					if (!empty($check_forwards)) {
						OutgoingMailForward::where('id',$check_forwards->id)->update($datas);
					}else{

						OutgoingMailForward::create($datas);
					}
				}
			}
			
			if (isset($request->attachments)) {
				foreach ($request->attachments as $k => $attach) {
					$upload = Upload::uploads(setting_by_code('PATH_DIGITAL_OUTGOING_MAIL'), $attach['file']);
					
					$model->attachments()->create([
						'attachment_name' => $attach['attachment_name'],
						'attachment_order' => $k + 1,
						'path_to_file' => !empty($upload) ? $upload : null
					]);
				}
			}
			
			if ($request->button_action == OutgoingMailStatusConstants::SEND_TO_REVIEW) {
				if ($model->from_employee_id != $request->from_employee_id) {
					$model->approvals()->delete();
				} else {
					foreach ($model->approvals as $appro) {
						$appro->update(['status' => 0]);
					}
				}
				
				foreach ($reviews as $review) {
					$model->approvals()->create([
						'structure_id' => $review['structure_id'],
						'employee_id' => $review['employee_id'],
						'status' => true
					]);
				}
				
				$model->update([
					'current_approval_structure_id' => $reviews[0]['structure_id'],
					'current_approval_employee_id' => $reviews[0]['employee_id'],
					'status' => OutgoingMailStatusConstants::REVIEW,
				]);
			}

			$model->update($request->all());
			
			if ($request->button_action == OutgoingMailStatusConstants::SEND_TO_REVIEW) {
				$this->send_email($model);
			}
			
            DB::commit();
        } catch (\Exception $ex) {
			DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
			
			return ['message' => config('constans.error.updated')];
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
		$model = OutgoingMailAttachment::findOrFail($attachment_id);
		$model->delete();
		
		return ['message' => config('constans.success.deleted')];
	}
	
	private function structure_from_employee($request)
	{
		$employee = employee_user($request->from_employee_id);
		
		$director_level = unserialize(setting_by_code('DIRECTOR_LEVEL_STRUCTURE'));
		
		if (in_array($employee->user->kode_struktur, $director_level)) {
			return true;
		}
		
		return false;
	}
	
	private function bottom_to_top($request)
	{
		$parent_id = Auth::user()->user_core->structure->parent_id;
		$this->parents[] = Auth::user()->user_core->structure->id;
		$employee = employee_user($request->from_employee_id);
		
		if ($employee->user->structure->id != Auth::user()->user_core->structure->id) {
			/* Search Hierarchy Structure Bottom to Top */
			$this->get_parent(OrganizationModel::find($parent_id), $employee->user->structure->id);
			/* Search Structure By Hierarchy Code */
		}

		return OrganizationModel::select('id','kode_struktur')
				->whereIn('id', $this->parents)
				->orderBy('id', 'DESC')
				->get();
	}
	
	private function get_parent($org, $end_structure)
	{
		if ($org) {
			$this->parents[] = $org->id;
			
			if ($org->id === $end_structure) {
				return;
			}
			
			$this->get_parent(OrganizationModel::find($org->parent_id), $end_structure);
		}
	}
	
	private function send_email($model)
	{
		$body = body_email($model, setting_name_by_code('SURAT_KELUAR'), EmailConstants::REVIEW);
		$email = smartdoc_user($model->current_approval_employee->user->user_id);
		$data = [
			'email' => !empty($email) ? $email->email : NULL,
			'name'  => $model->current_approval_employee->name,
			'notification_action' => config('constans.notif-email.'. EmailConstants::REVIEW),
			'body' => $body,
			'button' => true,
			'url' => setting_by_code('URL_APPROVAL_OUTGOING_MAIL')
		];
		
		dispatch(new SendEmailReminderJob($data));
	}
	
	public function download_attachment($attachment_id)
    {
		$model = OutgoingMailAttachment::findOrFail($attachment_id);
		Upload::download($model->path_to_file);
		
		return $model->path_to_file;
	}
}
