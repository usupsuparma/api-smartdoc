<?php namespace App\Modules\Master\TypeNote\Repositories;
/**
 * Class TypeNoteRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Master\TypeNote\Interfaces\TypeNoteInterface;
use App\Modules\Master\TypeNote\Models\TypeNoteModel;
use Validator;

class TypeNoteRepositories extends BaseRepository implements TypeNoteInterface
{
	public function model()
	{
		return TypeNoteModel::class;
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
			'code' => 'required|unique:type_notes,code,NULL,id,deleted_at,NULL',
			'name' => 'required|unique:type_notes,name,NULL,id,deleted_at,NULL',
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
			'code' => 'required|unique:type_notes,code,' . $id . ',id,deleted_at,NULL',
			'name' => 'required|unique:type_notes,name,' . $id . ',id,deleted_at,NULL',
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
