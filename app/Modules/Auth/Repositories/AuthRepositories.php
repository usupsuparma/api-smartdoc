<?php namespace App\Modules\Auth\Repositories;
/**
 * Class AuthRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Auth\Interfaces\AuthInterface;
use App\Modules\User\Models\UserModel;
use GuzzleHttp\Client;
use Validator;
use Auth;
use App\Traits\ApiResponse;
use Carbon\Carbon;

class AuthRepositories extends BaseRepository implements AuthInterface
{
	use ApiResponse;
	
	protected $login_max = 3;
	
	public function model()
	{
		return UserModel::class;
	}
	
    public function login($request)
    {
		$rules = [
			'username' => 'required',
			'password' => 'required'
		];
		
		Validator::validate($request->all(), $rules);
				
		$validation_login = $this->validLogin($request);
		
		if (!$validation_login['valid_login']) {
			return $validation_login;
		}
		
        return $this->processAuth($request);
	}
	
	public function validLogin($request) 
	{
		$messages = [];
		$valid_login = false;
		
		$user_data = $this->model->where([
			'email' => $request->username
		]);
		
		if ($user_data->exists()) {
			$user = $user_data->first();
			$login_count = $user->log_date == Carbon::now()->toDateString() ? $user->count_login : 0;
			$login_max = $this->login_max;
			
			if ($login_max <= $login_max && $user->status == 1) {
				$messages[] = 'Username atau password salah.';
				
				if (app('hash')->check($request->password, $user->password) && $login_count < $login_max) {
					$valid_login = true;
					return ['messages' => $messages , 'valid_login' => $valid_login];
				}
				
				$valid_login = false;
				$login_count++;

				if ($login_count < $login_max) {
					$is_banned = false;
					$messages[] = 'Kesempatan anda untuk login ' . ($login_max - $login_count) . ' kali lagi.';
				} else {
					$is_banned = true;
					$messages[] = 'Kesempatan login anda sudah habis , silahkan hubungi Administrator.';
				}
				
				$user->update([
					'count_login' => $login_count,
					'log_date' => Carbon::now()->toDateString(),
					'is_banned' => $is_banned
				]);
				
			} else {
				$messages[] = 'Anda sudah tidak bisa login , silahkan hubungi Administrator.';
			}
			
		} else {
			$messages[] = 'Akun anda belum terdaftar.';
		}
		
		return ['messages' => $messages , 'valid_login' => $valid_login];
	}
	
	public function processAuth($request)
	{
		$guzzle = new Client;
		$web_client_id = env('GRANT_CLIENT_ID');
		$web_client_secret = env('GRANT_CLIENT_SECRET');
		$mobile_client_id = env('MOBILE_CLIENT_ID');
		$mobile_client_secret = env('MOBILE_CLIENT_SECRET');

		if (isset($request->grant) && $request->grant == 'm') {
			$client_id = $mobile_client_id;
			$client_secret = $mobile_client_secret;
		} else {
			$client_id = $web_client_id;
			$client_secret = $web_client_secret;
		}
		
		$response = $guzzle->post(env('APP_LOCAL_URL', 'http://localhost') . '/api/v1/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'username' => $request->username,
                'password' => $request->password,
                'scope' => '*',
            ],
		]);
		
        $data = json_decode($response->getBody(), true);
		
		$detail = [];
		$user = UserModel::findByEmail($request->username)->first();
		$users_info = [];
		
		if (!empty($user->user_core_id)) {
			$users_info = core_user($user->user_core_id);
		}
		
		if (isset($request->grant) && $request->grant == 'm') {
			$user->update(['device_id' => $request->device_id]);
		}
		
		if ($users_info) {
			$detail = [
				'employee' => [
					'nik' => !empty($users_info->employee) ? $users_info->employee->nik : '',
					'name' => !empty($users_info->employee) ? $users_info->employee->name : ''
				],
				'department' => [
					'name' => !empty($users_info->structure) ? $users_info->structure->nama_struktur : ''
				],
				'potition' => [
					'name' => !empty($users_info->position) ? $users_info->position->nama_jabatan : ''
				]
			];
		}
		
		$results = [
			'user_info' => $detail,
			'token' => $data['access_token'],
			'refresh_token' => $data['refresh_token'],
			'message' => 'Berhasil Login',
		];
		
		return $results;
	}
	
	public function logout($request)
	{
		/* Remove device_id if logout type mobile */
		if ($request->has('type') && !empty($request->type)) {
			$model = UserModel::findOrFail(Auth::user()->id);
			$model->update(['device_id' => null]);
		}

		if (isset(Auth::user()->id)) {
			Auth::user()->token()->revoke();
			
			return ['message' => 'Berhasil Logout'];
		}
		
		return ['message' => 'Gagal Logout'];
	}
	
	public function refresh_token($request) 
	{
		$guzzle = new Client;
		$web_client_id = env('GRANT_CLIENT_ID');
		$web_client_secret = env('GRANT_CLIENT_SECRET');
		$mobile_client_id = env('MOBILE_CLIENT_ID');
		$mobile_client_secret = env('MOBILE_CLIENT_SECRET');

		if (isset($request->grant) && $request->grant == 'm') {
			$client_id = $mobile_client_id;
			$client_secret = $mobile_client_secret;
		} else {
			$client_id = $web_client_id;
			$client_secret = $web_client_secret;
		}
		
		$response = $guzzle->post(env('APP_LOCAL_URL', 'http://localhost') . '/api/v1/oauth/token', [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'refresh_token' => $request->refresh_token,
                'scope' => '',
            ],
		]);
		
		
		$detail = [];
        $data = json_decode($response->getBody(), true);
		
		if (!empty(Auth::user()->user_core)) {
			$detail = [
				'employee' => [
					'nik' => !empty(Auth::user()->user_core->employee) ? Auth::user()->user_core->employee->nik : '',
					'name' => !empty(Auth::user()->user_core->employee) ? Auth::user()->user_core->employee->name : ''
				],
				'department' => [
					'name' => !empty(Auth::user()->user_core->structure) ? Auth::user()->user_core->structure->nama_struktur : ''
				],
				'potition' => [
					'name' => !empty(Auth::user()->user_core->position) ? Auth::user()->user_core->position->nama_jabatan : ''
				]
			];
		}
		
		$results = [
			'user_info' => $detail,
			'token' => $data['access_token'],
			'refresh_token' => $data['refresh_token'],
			'message' => 'Berhasil Memulihkan Token',
		];
		
		return $results;
	}
    
}
