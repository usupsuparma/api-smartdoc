<?php namespace App\Modules\Auth\Repositories;
/**
 * Class UserRepositories.
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
		
		$response = $guzzle->post(env('APP_LOCAL_URL', 'http://localhost') . '/api/v1/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $web_client_id,
                'client_secret' => $web_client_secret,
                'username' => $request->username,
                'password' => $request->password,
                'scope' => '*',
            ],
		]);
		
        $data = json_decode($response->getBody(), true);
		
		$results = [
			'token' => $data['access_token'],
			'refresh_token' => $data['refresh_token'],
			'message' => 'Berhasil Login',
		];
		
		return $results;
	}
	
	public function logout()
	{
		if (isset(Auth::user()->id)) {
			Auth::user()->token()->revoke();
			
			return ['message' => 'Berhasil Logout'];
		}
		
		return ['message' => 'Gagal Logout'];
	}
    
}
