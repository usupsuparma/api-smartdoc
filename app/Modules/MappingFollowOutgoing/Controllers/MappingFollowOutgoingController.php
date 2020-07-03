<?php namespace App\Modules\MappingFollowOutgoing\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\MappingFollowOutgoing\Repositories\MappingFollowOutgoingRepositories;
use Authority, Auth;

class MappingFollowOutgoingController extends BaseController 
{
	private $mappingOutgoingRepository;
	
	public function __construct(MappingFollowOutgoingRepositories $mappingOutgoingRepository) 
	{
		$this->mappingOutgoingRepository = $mappingOutgoingRepository;
		Authority::acl_access(Auth::user(), 'mapping-follow-outgoing');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->mappingOutgoingRepository->data($request),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
        return $this->successResponse($this->mappingOutgoingRepository->create($request), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->mappingOutgoingRepository->delete($id), 200); 
	}
}