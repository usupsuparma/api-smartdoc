<?php namespace App\Modules\External\Users\Repositories;
/**
 * Class UsersRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\External\Users\Interfaces\UsersInterface;
use App\Modules\External\Users\Models\ExternalUserModel;
use App\Modules\User\Models\UserModel;
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
		$rules = [
			'user_core_id' => 'required|unique:users,user_core_id',
			'email' => 'required|unique:users,email',
			'password' => 'required',
		];
		
		Validator::validate($request->all(), $rules);
		
		$model = UserModel::create([
			'user_core_id' => $request->user_core_id,
			'email' => $request->email,
			'username' => $request->email,
			'password' => app('hash')->make($request->password),
			'status' => true,
		]);

		created_log($model);
		
		return [
			'message' => config('constans.success.created'),
			'status' => true
		];
		
	}
	
	public function update($request, $id)
    {
		$model = UserModel::findCoreUser($id)->firstOrFail();
		
		$rules = [
			'email' => 'required|unique:users,email,' . $id . ',id,deleted_at,NULL'
		];
		
		Validator::validate($request->all(), $rules);
		
		$model->update([
			'email' => $request->email,
			'username' => $request->email
		]);
		
		updated_log($model);
		
		return [
			'message' => config('constans.success.updated'),
			'status' => true
		];
	}
	
	public function delete($id)
    {
		// $model = $this->model->findOrFail($id);
		// deleted_log($model);
		// $model->delete();
		
		// return ['message' => config('constans.success.deleted')];
	}
}
