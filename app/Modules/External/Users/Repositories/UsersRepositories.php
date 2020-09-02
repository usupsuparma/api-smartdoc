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
	
	public function data_ex($request)
    {
		$query = $this->model->where('status', $request->status);
		
		if ($request->has('keyword') && !empty($request->keyword)) {
			
			$query->whereHas('employee', function ($q) use ($request) {
				$q->where('name', 'like', "%{$request->keyword}%");
				$q->orWhere('nik', 'like', "%{$request->keyword}%");
			});
		}
		
		if ($request->has('id_employee') && !empty($request->id_employee)) {
			$query->where('id_employee', $request->id_employee);
		}
		
		if ($request->has('kode_struktur') && !empty($request->kode_struktur)) {
			$query->where('kode_struktur', $request->kode_struktur);
		}
		
		if ($request->has('kode_jabatan') && !empty($request->kode_jabatan)) {
			$query->where('kode_jabatan', $request->kode_jabatan);
		}
		
		return $query->get();
	}
	
	public function show_ex($id)
    {
        return $this->model->findOrFail($id);
	}
	
	public function create_ex($request)
    {
		$rules = [
			'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:external_users,email,NULL,user_id,deleted_at,NULL',
			'id_employee' => 'required|unique:external_users,id_employee,NULL,user_id,deleted_at,NULL',
			'kode_struktur' => 'required',
			'kode_jabatan' => 'required',
			'status' => 'required',
		];
		
		Validator::validate($request->all(), $rules);
		
		$model = $this->model->create($request->all());

		created_log($model);
		
		return ['message' => config('constans.success.created')];
	}
	
	public function update_ex($request, $id)
    {
		$input = $request->all();
		$rules = [
			'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:external_employees,email,' . $id . ',user_id,deleted_at,NULL',
			'id_employee' => 'required|unique:external_employees,id_employee,' . $id . ',user_id,deleted_at,NULL',
			'kode_struktur' => 'required',
			'kode_jabatan' => 'required',
			'status' => 'required',
		];
		
		Validator::validate($input, $rules);
		
		$model = $this->model->findOrFail($id);
		$model->update($input);
		
		updated_log($model);
		
		return ['message' => config('constans.success.updated')];
	}
	
	public function delete_ex($id)
    {
		$model = $this->model->findOrFail($id);
		deleted_log($model);
		$model->delete();
		
		
		return ['message' => config('constans.success.deleted')];
	}
}
