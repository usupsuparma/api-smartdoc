<?php namespace App\Modules\Master\ClassDisposition\Repositories;
/**
 * Class ClassDispositionRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Master\ClassDisposition\Interfaces\ClassDispositionInterface;
use App\Modules\Master\ClassDisposition\Models\ClassDispositionModel;
use Validator;

class ClassDispositionRepositories extends BaseRepository implements ClassDispositionInterface
{
	public function model()
	{
		return ClassDispositionModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->where('status', $request->status);
		
		if ($request->has('name') && !empty($request->name)) {
			$query->where('name', 'like', "%{$request->name}%");
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
			'name' => 'required|unique:class_disposition,name,NULL,id,deleted_at,NULL',
			'status' => 'required'
		];
		
		Validator::validate($request->all(), $rules);
		
		$model = $this->model->create($request->all());

		created_log($model);
		
		return ['message' => config('constans.success.created')];
	}
	
	public function update($request, $id)
    {
		$input = $request->all();
		$rules = [
			'name' => 'required|unique:class_disposition,name,' . $id . ',id,deleted_at,NULL',
			'status' => 'required'
		];
		
		Validator::validate($input, $rules);
		
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
	
	public function options()
	{
		return ['data' => $this->model->options()];
	}
}
