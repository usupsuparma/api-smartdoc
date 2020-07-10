<?php namespace App\Modules\OutgoingMail\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\OutgoingMail\Repositories\FollowUpOutgoingMailRepositories;
use Authority, Auth;

class FollowUpOutgoingMailController extends BaseController 
{
	private $followUpOutgoingMailRepository;
	
	public function __construct(FollowUpOutgoingMailRepositories $followUpOutgoingMailRepository) 
	{
		$this->followUpOutgoingMailRepository = $followUpOutgoingMailRepository;
		// Authority::acl_access(Auth::user(), 'outgoing-mails-follow');
	}
	
	public function data(Request $request)
	{
		// Authority::check('read');
		
		return $this->showAll($this->followUpOutgoingMailRepository->data($request),200);
	}
	
	public function show($id)
	{
		// Authority::check('read');
		
		return $this->successResponse($this->followUpOutgoingMailRepository->show($id),200);
	}
	
	public function follow_up(Request $request, $id)
	{
		// Authority::check('create');
		
		$results = $this->followUpOutgoingMailRepository->follow_up($request, $id);
		
        return $this->successResponse($results, 200);
	}
	
	public function download($id)
    {
		$path = storage_path('app/public'. $this->followUpOutgoingMailRepository->download($id));

		return response()->download($path, basename($path));
	}
}