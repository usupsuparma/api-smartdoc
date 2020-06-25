<?php namespace App\Modules\Auth\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Library\Bases\BaseController;
use Illuminate\Http\Request;
use App\Modules\Auth\Repositories\AuthRepositories;

class AuthController extends BaseController 
{
	private $authRepository;
	
    public function __construct(AuthRepositories $authRepository)
    {
        $this->authRepository = $authRepository;
	}
	
	public function login(Request $request)
	{
		$results = $this->authRepository->login($request);
		
		if (isset($results['valid_login'])) {
			if (!$results['valid_login']) {
				return $this->errorResponse($results['messages'], 409);
			}
		}
		
        return $this->successResponse($results, 200);
	} 
	
	public function logout()
	{
		return $this->successResponse($this->authRepository->logout(), 200);
	}
	
	public function refresh_token(Request $request)
	{
		$results = $this->authRepository->refresh_token($request);
		
        return $this->successResponse($results, 200);
	} 
}