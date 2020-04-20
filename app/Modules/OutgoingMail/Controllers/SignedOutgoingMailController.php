<?php namespace App\Modules\OutgoingMail\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\OutgoingMail\Repositories\SignedOutgoingMailRepositories;
use Authority, Auth;

class SignedOutgoingMailController extends BaseController 
{
	private $signedOutgoingMailRepository;
	
	public function __construct(SignedOutgoingMailRepositories $signedOutgoingMailRepository) 
	{
		$this->signedOutgoingMailRepository = $signedOutgoingMailRepository;
		Authority::acl_access(Auth::user(), 'outgoing-mails-signed');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->signedOutgoingMailRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->successResponse($this->signedOutgoingMailRepository->show($id),200);
	}
	
	public function update(Request $request, $id)
	{
		Authority::check('approve');
		
		$results = $this->signedOutgoingMailRepository->update($request, $id);
		
		if (!$results['status']) {
			return $this->errorResponse($results, 422);
		}
		
        return $this->successResponse($results, 200);
	}
}