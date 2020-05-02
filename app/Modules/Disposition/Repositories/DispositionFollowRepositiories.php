<?php namespace App\Modules\Disposition\Repositories;
/**
 * Class DispositionFollowRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Disposition\Interfaces\DispositionFollowInterface;
use App\Modules\Disposition\Models\DispositionModel;
use App\Modules\Disposition\Transformers\DispositionTransformer;
use App\Modules\Disposition\Models\DispositionFollowUp;
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use Validator, Auth;
use Upload;


class DispositionFollowRepositories extends BaseRepository implements DispositionFollowInterface
{	
	public function model()
	{
		return DispositionModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->followUpEmployee();
		
		if ($request->has('keyword') && !empty($request->keyword)) {
			$query->where('subject_disposition', 'like', "%{$request->keyword}%");
			$query->orWhere('number_disposition', 'like', "%{$request->keyword}%");
		}
		
		if ($request->has('start_date') &&  $request->has('end_date')) {
			if (!empty($request->start_date) && !empty($request->end_date)) {
				$query->whereBetween('disposition_date', [$request->start_date, $request->end_date]);	
			}
		}

		return $query->get(); 
	}
	
	public function show($id)
    {
		$data =  $this->model->followUpEmployee()->where('id', $id)->firstOrFail();
		
		return ['data' => DispositionTransformer::customTransform($data)];
	}
	
	public function follow_up($request, $id)
	{
		$model = $this->model->with('assign')->followUpEmployee()->where('id', $id)->firstOrFail();
		$employee_id = Auth::user()->user_core->id_employee;
		$collection = collect($model->assign);

		$filtered = $collection->filter(function ($value, $key) use ($employee_id) {
			return $value['employee_id'] == $employee_id;
		});

		$results = $filtered->flatten()->all()[0];

		if (!$results->follow_ups->isEmpty()) {
			return [
				'message' => 'Maaf anda sudah memberikan tindak lanjut !',
				'status' => false
			];	
		}

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
			$upload = Upload::uploads(setting_by_code('PATH_DIGITAL_DISPOSITION'), $request->file);
		}
		
		DispositionFollowUp::create([
			'dispositions_assign_id' => $results->id,
			'employee_id' => Auth::user()->user_core->id_employee,
			'description' => $request->description,
			'path_to_file' => !empty($upload) ? $upload : null,
			'status' => true,
		]);
		
		$check = $this->model->findOrFail($id);
		$count = 0;
	   	if (!empty($check->assign)) {
			foreach ($check->assign as $assign) {
				if (!empty($assign->follow_ups[0])) {
					$count++;
				}
			}
		}

		if ($count == $check->assign->count()) {
			$model->update([
				'status' => IncomingMailStatusConstans::DONE
			]);
		}
		
		return ['message' => config('constans.success.follow-up'), 'status' => true];
	}
	
	public function download($id)
    {
		$model = $this->model->findOrFail($id);
		
		if (!empty($model->subject_letter)) {
			Upload::download($model->path_to_file);
		}
		
		return $model->path_to_file;
	}
	
}
