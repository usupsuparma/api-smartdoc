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
use Validator, DB, Auth;
use Upload;

class OutgoingMailRepositories extends BaseRepository implements OutgoingMailInterface
{
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
		
		return OutgoingMailTransformer::customTransform($data);
	}
	
	public function create($request)
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
		
		if (!empty($request->attachments)) {
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
		
		if (!empty($request->copy_of_letter)) {
			foreach ($request->copy_of_letter as $key => $col) {
				$rules['copy_of_letter.'.$key] = ['required'];
				$message['copy_of_letter.'.$key.'.required'] = 'Tembusan '.$key. ' wajib diisi';
			}
		} 
		
		Validator::validate($request->all(), $rules, $message);
		
		/* check list review */
		$reviews = review_list(setting_by_code('SURAT_KELUAR'));
		
		DB::beginTransaction();

        try {
			$model = $this->model->create($request->merge([
				'status' => OutgoingMailStatusConstants::DRAFT,
				'created_by_employee' => Auth::user()->user_core->id_employee,
				'created_by_structure' => Auth::user()->user_core->structure->id,
			])->all());
			
			foreach ($request->copy_of_letter as $copy) {
				$model->forwards()->create(['employee_id' => $copy]);
			}
			
			if (!empty($request->attachments)) {
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
					$model->approvals()->create(['structure_id' => $review]);
				}
				
				$model->update([
					'current_approval_structure_id' => $reviews[0],
					'status' => OutgoingMailStatusConstants::SEND_TO_REVIEW,
				]);
			}
			
            DB::commit();
        } catch (\Exception $ex) {
			DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
			
			return ['message' => config('constans.error.created')];
		}

		created_log($model);
		
		return ['message' => config('constans.success.created')];
		
	}
	
	public function update($request, $id)
    {
		$input = $request->all();
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
		
		Validator::validate($input, $rules, $message);
		
		$model = $this->model->findOrFail($id);
		$model->update($input);
		
		updated_log($model);
		
		return ['message' => config('constans.success.updated')];
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
	
	public function approve($request)
	{
		
	}
	
	public function publish($request)
	{
		
	}
}
