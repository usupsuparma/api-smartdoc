<?php namespace App\Modules\Verification\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Verification\Repositories\VerificationRepositories;

class VerificationController extends BaseController 
{
	private $verificationRepository;
	
	public function __construct(VerificationRepositories $verificationRepository) 
	{
		$this->verificationRepository = $verificationRepository;
	}
	
	public function verify(Request $request)
	{
		$results = $this->verificationRepository->verify($request);
		
		if (!$results['status']) {
			return $this->errorResponse($results, 404);
		}
		
		return $this->successResponse($results, 200);
	}
}