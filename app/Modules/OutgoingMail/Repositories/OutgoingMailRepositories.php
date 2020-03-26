<?php namespace App\Modules\OutgoingMail\Repositories;
/**
 * Class OutgoingMailRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\OutgoingMail\Interfaces\OutgoingMailInterface;
use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use Validator;

class OutgoingMailRepositories extends BaseRepository implements OutgoingMailInterface
{
	public function model()
	{
		return OutgoingMailModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->where('status', $request->status);
		
		if ($request->has('keyword') && !empty($request->keyword)) {
			$query->where('subject_letter', 'like', "%{$request->keyword}%");
		}
		
		return $query->get();
	}
	
	public function show($id)
    {
        return $this->model->findOrFail($id);
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
		
		Validator::validate($request->all(), $rules, $message);
		
		$model = $this->model->create($request->all());

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
	
	public function approve($request)
	{
		
	}
	
	public function publish($request)
	{
		
	}
}
