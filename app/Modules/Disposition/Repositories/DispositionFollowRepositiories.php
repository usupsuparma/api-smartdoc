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
use App\Modules\Disposition\Models\DispositionAssign;
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use App\Constants\MailCategoryConstants;
use App\Events\Notif;
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
	
	public function show_follow_up($id)
    {
		$data =  $this->model->followUpEmployee()->where('id', $id)->firstOrFail();
		$dispo_assign = DispositionAssign::CheckRead($id);
		if ($dispo_assign) {
			$dispo_assign->update([
				'is_read' => true
			]);
		}

		return ['data' => DispositionTransformer::customTransform($data)];
	}
	
	public function show($id)
    {
		$dispo_assign = DispositionAssign::CheckRead($id);
		if ($dispo_assign) {
			$dispo_assign->update([
				'is_read' => true
			]);
		}
		
		$follow_up = DispositionFollowUp::followUp($dispo_assign->id)->first();

		return ['data' => $follow_up ? DispositionTransformer::followUpTransform($follow_up) : null];
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
		
		// if (!$results->follow_ups->isEmpty()) {
		// 	return [
		// 		'message' => 'Maaf anda sudah memberikan tindak lanjut !',
		// 		'status' => false
		// 	];	
		// }

		$rules = [
			'description' => 'required'
		];
		
		$message = [
			'description.required' => 'catatan tindak lanjut wajib diisi'
		];
		
		if ($request->hasFile('file')) {
			$rules['file'] = ['mimes:pdf,jpg,jpeg,png|max:2048'];
			$message['file.mimes'] = 'file harus berupa berkas berjenis: pdf, jpg, jpeg, png.';
		}
		
		Validator::validate($request->all(), $rules, $message);
		
		$data_follow_up = [
			'description' => $request->description,
			'progress' => $request->progress,
			'status' => true,
		];
		
		$upload = null;
		
		if ($request->hasFile('file')) {
			$upload = Upload::uploads(setting_by_code('PATH_DIGITAL_DISPOSITION'), $request->file);
			$data_follow_up['path_to_file'] = !empty($upload) ? $upload : null;
		}
		
		DispositionFollowUp::updateOrCreate([
			'dispositions_assign_id' => $results->id,
			'employee_id' => Auth::user()->user_core->id_employee,
		], $data_follow_up);
		
		
		$check = $this->model->findOrFail($id);
		$count = 0;
	   	if (!empty($check->assign)) {
			foreach ($check->assign as $assign) {
				if (
					!empty($assign->follow_ups[0]) && 
					$assign->follow_ups[0]->progress === IncomingMailStatusConstans::FOLLOW_UP_FINISH
				) {
					$count++;
				}
			}
		}

		if ($count == $check->assign->count()) {
			$model->update([
				'status' => IncomingMailStatusConstans::DONE
			]);
		}
		
		/* Notification */
		push_notif([
			'device_id' => find_device_mobile($model->from_employee_id),
			'data' => ['route_name' => 'Disposition'],
			'heading' => '[SURAT DISPOSISI]',
			'content' => "Finish Follow Up - {$model->subject_disposition} sudah selesai di tindak lanjuti oleh ". Auth::user()->user_core->employee->name
		]);
		
		$this->send_notification([
			'model' => $model, 
			'heading' => MailCategoryConstants::SURAT_DISPOSISI,
			'title' => 'finish-follow-up-disposition', 
			'receiver' => $model->from_employee_id
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
			'redirect_web' => setting_by_code('URL_DISPOSITION'),
			'redirect_mobile' => serialize([
				'route_name' => 'Disposition',
			]),
			'receiver_id' => $notif['receiver'],
			'type' => source_type("DI", $notif['model']),
			'employee_name' => Auth::user()->user_core->employee->name,
		];
		
		event(new Notif($data_notif));
	}
	
}
