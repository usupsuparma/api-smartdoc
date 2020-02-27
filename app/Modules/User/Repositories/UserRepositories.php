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
        return $this->model->get();
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
				'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/'
			],
			'status' => 'required'
		];
		
		$message = [
			'password.regex' => ':attribute harus terdapat nomer, simbol, huruf besar dan kecil .'
		];
		
		Validator::validate($request->all(), $rules, $message);
		
		return $this->model->create($request->merge([
            'password' => app('hash')->make($request->password),
        ])->all())->id;
	}
	
	public function update($request, $id)
    {
		$input = $request->all();
		$rules = [
			// 'employee_id' => 'required',
			// 'role_id' => 'required',
			'username' => 'required|min:8|unique:users,username,' . $id,
			'email' => 'required|unique:users,email,' . $id,
			'status' => 'required',
		];
		
		$message = [];
		
		if (!empty($input['password'])) {
			$rules['password'] = [
				'required', 
				'min:8', 
				'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/'
			];
			$message = [
				'password.regex' => ':attribute harus terdapat nomer, simbol, huruf besar dan kecil .'
			];
		} else {
			unset($input['password']);
		}
		
		Validator::validate($input, $rules, $message);
		
		$this->model->findOrFail($id)->update($input);
		
		return $id;
	}
	
	public function delete($id)
    {
		$query = $this->model->findOrFail($id)->delete();
		
		return $query;
    }
    
}
