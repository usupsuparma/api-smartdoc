<?php namespace App\Modules\SpecialDivisionOutgoing\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\SpecialDivisionOutgoing\Repositories\SpecialDivisionOutgoingRepositories;
use Authority, Auth;

class SpecialDivisionOutgoingController extends BaseController 
{
	private $specialDivisionRepository;
	
	public function __construct(SpecialDivisionOutgoingRepositories $specialDivisionRepository) 
	{
		$this->specialDivisionRepository = $specialDivisionRepository;
		Authority::acl_access(Auth::user(), 'special-division-outgoing');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->specialDivisionRepository->data($request),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
        return $this->successResponse($this->specialDivisionRepository->create($request), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->specialDivisionRepository->delete($id), 200); 
	}
}