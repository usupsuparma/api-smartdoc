<?php namespace App\Modules\Archive\Repositories;
/**
 * Class ArchiveIncomingRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Archive\Interfaces\ArchiveIncomingInterface;
use App\Modules\IncomingMail\Models\IncomingMailModel;
use App\Modules\IncomingMail\Transformers\IncomingMailTransformer;


class ArchiveIncomingRepositories extends BaseRepository implements ArchiveIncomingInterface
{
	public function model()
	{
		return IncomingMailModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->authorityData()->isArchive();
		
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
		$data =  $this->model->isArchive()
				->where('id', $id)->firstOrFail();
		
		return ['data' => IncomingMailTransformer::customTransform($data)];
	}
}
