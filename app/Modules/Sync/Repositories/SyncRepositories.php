<?php namespace App\Modules\Sync\Repositories;
/**
 * Class SignatureRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Sync\Interfaces\SyncInterface;
use App\Modules\Sync\Models\SyncModel;
use App\Modules\External\Users\Models\ExternalUserModel;
use App\Modules\User\Models\UserModel;
use GuzzleHttp\Client;
use Auth, DB;
use Faker\Factory as Faker;

class SyncRepositories extends BaseRepository implements SyncInterface
{
	public function model()
	{
		return SyncModel::class;
	}
	
    public function data()
    {
		return $this->model->get();
	}
	
	public function generate_sync()
    {	
		$externalUsers = ExternalUserModel::readySyncUser()->get();
		$faker = Faker::create();
		
		DB::beginTransaction();

        try {
			foreach ($externalUsers as $eUser) {
				$user = UserModel::findCoreUser($eUser->user_id)->first();
				$email = $faker->safeEmail;
				if ($user === null) {
					$password = !empty($eUser->employee) ? $eUser->employee->nik : 'hello';
					UserModel::create([
						'user_core_id' => $eUser->user_id,
						'email' => $email,
						'username' => $email,
						'password' => app('hash')->make($password),
						'status' => true,
					]);
				} else {
					$user->update([
						'email' => $email,
					]);
				}
			}
			
			$this->model->create([
				'user_id' => Auth::user()->id,
				'description' => 'User Sync Successfully'
			]);
			
            DB::commit();
        } catch (\Exception $ex) {
			DB::rollback();
            return ['message' => $ex->getMessage(), 'status' => false];
		}

		return [
			'message' => config('constans.success.sync'),
			'status' => true
		];
	}
	
	public function generate_token_client()
	{
		$guzzle = new Client;

		try {
			$response = $guzzle->post(env('APP_LOCAL_URL', 'http://localhost') . '/api/v1/oauth/token', [
				'form_params' => [
					'grant_type' => 'client_credentials',
					'client_id' => env('BIJB_CLIENT_ID'),
					'client_secret' => env('BIJB_CLIENT_SECRET'),
					'scope' => '*',
				],
			]);
			
			$data = json_decode($response->getBody(), true);
			
			return [
				'data' => !empty($data) ? $data : NULL
			];

        } catch (\Exception $ex) {

            return ['message' => $ex->getMessage(), 'status' => false];
		}
	}
}
