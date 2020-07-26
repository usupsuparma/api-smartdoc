<?php namespace App\Modules\Archive\Repositories;
/**
 * Class ArchiveDispositionRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Archive\Interfaces\ArchiveDispositionInterface;
use App\Modules\Disposition\Models\DispositionModel;
use App\Modules\Disposition\Transformers\DispositionTransformer;


class ArchiveDispositionRepositories extends BaseRepository implements ArchiveDispositionInterface
{
	public function model()
	{
		return DispositionModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->authorityData()->isArchive();
		
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
		$data =  $this->model->isArchive()
				->where('id', $id)->firstOrFail();
		
		return ['data' => DispositionTransformer::customTransform($data)];
	}
}
