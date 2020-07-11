<?php namespace App\Modules\Account\Repositories;
/**
 * Class AccountRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Account\Interfaces\AccountInterface;
use App\Modules\Account\Models\AccountModel;
use App\Jobs\SendEmailChangePasswordJob;
use Auth, Validator;

class AccountRepositories extends BaseRepository implements AccountInterface
{	
	public function model()
	{
		return AccountModel::class;
	}
	
    public function show()
    {
		return $this->model->findOrFail(Auth::user()->id);
	}
	
	public function change_password($request)
    {
		$model = $this->model->findOrFail(Auth::user()->id);
		
		Validator::extend('match_password', function () use ($request, $model) {
			if (!empty($request->old_password)) {
				return app('hash')->check($request->old_password, $model->password);
			}
        });

		$rules = [
			'old_password' => 'required|match_password',
			'new_password' => [
				'required', 
				'min:8', 
				'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@#$%^&*()<>?]).*$/'
			],
			'new_confirm_password' => 'same:new_password'
		];
		
		$message = [
			'new_password.regex' => ':attribute harus terdapat nomer, simbol, huruf besar dan kecil .',
			'old_password.match_password' => ':attribute tidak sesuai .',
		];
		
		Validator::validate($request->all(), $rules, $message);
		
		$model->update([
			'password' => app('hash')->make($request->new_confirm_password)
		]);
		
		$this->send_email($model, $request);
		
		updated_log($model);
		
		return ['message' => config('constans.success.updated')];
	}
	
	private function send_email($model, $request)
	{
		$data = [
			'email' => $model->email,
			'name'  => '',
			'new_confirm_password' => $request->new_confirm_password
		];
		
		dispatch(new SendEmailChangePasswordJob($data));
	}
}
