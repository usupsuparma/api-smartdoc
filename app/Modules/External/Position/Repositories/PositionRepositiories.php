<?php namespace App\Modules\External\Position\Repositories;
/**
 * Class PositionRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\External\Position\Interfaces\PositionInterface;
use App\Modules\External\Position\Models\PositionModel;
use Validator;

class PositionRepositories extends BaseRepository implements PositionInterface
{
	public function model()
	{
		return PositionModel::class;
	}
	
	public function options()
	{
		return ['data' => $this->model->options()];
	}
	
	public function data($request)
    {
		$query = $this->model->where('status', $request->status);
		
		if ($request->has('keyword') && !empty($request->keyword)) {
			$query->where('nama_jabatan', 'like', "%{$request->keyword}%");
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
			'nama_jabatan' => 'required|unique:external_positions,nama_jabatan,NULL,id',
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
			'nama_jabatan' => 'required|unique:external_positions,nama_jabatan,' . $id . ',id',
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
	
	public function select_type()
	{
		return ['data' => $this->model->options(setting_by_code('SELECT_TYPE'))];
	}
}
