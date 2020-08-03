<?php namespace App\Modules\OutgoingMail\Repositories;
/**
 * Class FollowUpOutgoingMailRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\OutgoingMail\Interfaces\FollowUpOutgoingMailInterface;
use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use App\Modules\OutgoingMail\Transformers\OutgoingMailTransformer;
use App\Modules\OutgoingMail\Models\OutgoingMailFollowUp;
use Validator, Upload, Auth;


class FollowUpOutgoingMailRepositories extends BaseRepository implements FollowUpOutgoingMailInterface
{	
	public function model()
	{
		return OutgoingMailModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->followUpEmployee();
		
		if ($request->has('keyword') && !empty($request->keyword)) {
			$query->where('subject_letter', 'like', "%{$request->keyword}%");
			$query->orWhere('number_letter', 'like', "%{$request->keyword}%");
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
		$data =  $this->model->followUpEmployee()->where('id', $id)->firstOrFail();
		
		return ['data' => OutgoingMailTransformer::customTransform($data)];
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
			$rules['file'] = ['mimes:pdf,jpg,jpeg,png|max:4096'];
			$message['file.mimes'] = 'file harus berupa berkas berjenis: pdf, jpg, jpeg, png.';
		}
		
		Validator::validate($request->all(), $rules, $message);
		
		$upload = null;

		if ($request->hasFile('file')) {
			$upload = Upload::uploads(setting_by_code('PATH_DIGITAL_OUTGOING_MAIL'), $request->file);
		}
		
		OutgoingMailFollowUp::create([
			'outgoing_mails_assign_id' => $results->id,
			'employee_id' => Auth::user()->user_core->id_employee,
			'description' => $request->description,
			'path_to_file' => !empty($upload) ? $upload : null,
			'status' => true,
		]);
		
		return ['message' => config('constans.success.follow-up'), 'status' => true];
	}
	
	public function download($id)
    {
		$model = $this->model->findOrFail($id);
		
		if (!empty($model->path_to_file)) {
			Upload::download($model->path_to_file);
		}
		
		return $model->path_to_file;
	}
}
