<?php namespace App\Modules\User\Repositories;
/**
 * Class UserRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\User\Interfaces\UserInterface;
use App\Modules\User\Models\UserModel;
use Validator;

class UserRepositories extends BaseRepository implements UserInterface
{
	public function model()
	{
		return UserModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->with(['user_core' => function ($q){
			$q->with(['employee']);
		}])->where('status', $request->status);
		
		if ($request->has('username') && !empty($request->username)) {
			$query->where('username', 'like', "%{$request->username}%");
		}
		
		if ($request->has('email') && !empty($request->email)) {
			$query->where('email', 'like', "%{$request->email}%");
		}
		
		$data = $query->get();
		if ($request->has('employee') && !empty($request->employee)) {
			$data = collect($data)->filter(function ($col) use ($request) {
                if (isset($col->user_core->employee)) {
                    return false !== stristr($col->user_core->employee->name, $request->employee);
                }
			});
		}

        return $data;
	}
	
	public function show($id)
    {
        return $this->model->findOrFail($id);
	}
	
	public function create($request)
    {
		$rules = [
			// 'employee_id' => 'required',
			// 'role_id' => 'required',
			'username' => 'required|min:8|unique:users,username',
			'email' => 'required|unique:users,email',
			'password' => [
				'required', 
				'min:8', 
				'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@#$%^&*()<>?]).*$/'
			],
			'status' => 'required'
		];
		
		$message = [
			'password.regex' => ':attribute harus terdapat nomer, simbol, huruf besar dan kecil .'
		];
		
		Validator::validate($request->all(), $rules, $message);
		
		$model = $this->model->create($request->merge([
            'password' => app('hash')->make($request->password),
		])->all());

		created_log($model);
		
		return ['message' => config('constans.success.created')];
	}
	
	public function update($request, $id)
    {
		$input = $request->all();

		$rules = [
			// 'employee_id' => 'required',
			'role_id' => 'required',
			// 'username' => 'required|min:8|unique:users,username,' . $id,
			// 'email' => 'required|unique:users,email,' . $id,
			// 'status' => 'required',
		];
		
		$message = [
			'role_id.required' => 'Role user wajib diisi . '
		];
		
		if (!empty($input['password'])) {
			$rules['password'] = [
				'required', 
				'min:8', 
				'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@#$%^&*()<>?]).*$/'
			];
			$message = [
				'password.regex' => ':attribute harus terdapat nomer, simbol, huruf besar dan kecil .'
			];
		} else {
			unset($input['password']);
		}
		
		Validator::validate($input, $rules, $message);
		
		$model = $this->model->findOrFail($id);
		// $input['password'] = app('hash')->make($request->password);
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
	
	public function reset_user($id)
	{
		$model = $this->model->findOrFail($id);
		$model->update([
			'password' => app('hash')->make('smartDoc'),
			'status' => true,
			'count_login' => NULL,
			'is_banned' => false,
			'log_date' => NULL,
		]);
		
		return ['message' => 'User berhasil di reset , gunakan password ***smartDoc*** untuk login pertama kali setelah user di reset.'];
	}
    
}
