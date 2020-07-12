<?php namespace App\Modules\External\Users\Repositories;
/**
 * Class UsersRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\External\Users\Interfaces\UsersInterface;
use App\Modules\External\Users\Models\ExternalUserModel;
use Validator;

class UsersRepositories extends BaseRepository implements UsersInterface
{
	protected $parents;
	
	public function model()
	{
		return ExternalUserModel::class;
	}
	
	public function create($request)
    {
		
		return [
			'message' => config('constans.success.created'),
			'status' => true
		];
		
	}
	
	public function update($request, $id)
    {
		$model = $this->model->findOrFail($id);
		
		
		return [
			'message' => config('constans.success.updated'),
			'status' => true
		];
	}
	
	public function delete($id)
    {
		$model = $this->model->findOrFail($id);
		deleted_log($model);
		$model->delete();
		
		return ['message' => config('constans.success.deleted')];
	}
}
