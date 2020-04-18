<?php namespace App\Modules\OutgoingMail\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\OutgoingMail\Repositories\AdminOutgoingMailRepositories;
use Authority, Auth;

class AdminOutgoingMailController extends BaseController 
{
	private $adminOutgoingMailRepository;
	
	public function __construct(AdminOutgoingMailRepositories $adminOutgoingMailRepository) 
	{
		$this->adminOutgoingMailRepository = $adminOutgoingMailRepository;
		Authority::acl_access(Auth::user(), 'outgoing-mails-admin');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->adminOutgoingMailRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->successResponse($this->adminOutgoingMailRepository->show($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
		$results = $this->adminOutgoingMailRepository->create($request);
		
		if (!$results['status']) {
			return $this->errorResponse($results, 422);
		}
		
        return $this->successResponse($results, 200);
	}
}