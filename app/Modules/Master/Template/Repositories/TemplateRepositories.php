<?php namespace App\Modules\Master\Template\Repositories;
/**
 * Class TemplateRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Master\Template\Interfaces\TemplateInterface;
use App\Modules\Master\Template\Models\TemplateModel;
use Validator;

class TemplateRepositories extends BaseRepository implements TemplateInterface
{
	public function model()
	{
		return TemplateModel::class;
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
			'name' => 'required|unique:templates,name,NULL,id,deleted_at,NULL',
			'type_id' => 'required',
			'template' => 'required',
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
			'name' => 'required|unique:templates,name,' . $id . ',id,deleted_at,NULL',
			'type_id' => 'required',
			'template' => 'required',
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
	
	public function template_by_type($type_id)
    {
		$model = $this->model->byType($type_id)->first();
		
		if ($model) {
			return ['data' => $model->template];
		}
		
		return NULL;
    }
}
