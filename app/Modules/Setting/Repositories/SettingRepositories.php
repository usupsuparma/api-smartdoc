<?php namespace App\Modules\Setting\Repositories;
/**
 * Class SettingRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Setting\Interfaces\SettingInterface;
use App\Modules\Setting\Models\SettingModel;
use Validator;

class SettingRepositories extends BaseRepository implements SettingInterface
{
	public function model()
	{
		return SettingModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->where('status', $request->status);
		
		if ($request->has('name') && !empty($request->name)) {
			$query->where('name', 'like', "%{$request->name}%");
			$query->orWhere('code', 'like', "%{$request->name}%");
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
			'name' => 'required|unique:settings,name,NULL,id,deleted_at,NULL',
			// 'code' => 'required|unique:settings,code,NULL,id,deleted_at,NULL',
			'value' => 'required',
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
			'name' => 'required|unique:settings,name,' . $id . ',id,deleted_at,NULL',
			// 'code' => 'required|unique:settings,code,' . $id . ',id,deleted_at,NULL',
			'value' => 'required',
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
}
