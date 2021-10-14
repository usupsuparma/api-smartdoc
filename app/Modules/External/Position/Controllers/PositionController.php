<?php namespace App\Modules\External\Position\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\External\Position\Repositories\PositionRepositories;
use Authority, Auth;

class PositionController extends BaseController 
{
	private $positionRepository;
	
	public function __construct(PositionRepositories $positionRepository) 
	{
		$this->positionRepository = $positionRepository;
	}
	
	public function options()
	{
		return $this->successResponse($this->positionRepository->options(),200);
	}
	
	public function data(Request $request)
	{
		Authority::acl_access(Auth::user(), 'positions');
		
		Authority::check('read');
		
		return $this->showAll($this->positionRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::acl_access(Auth::user(), 'positions');
		
		Authority::check('read');
		
		return $this->showOne($this->positionRepository->show($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::acl_access(Auth::user(), 'positions');
		
		Authority::check('create');
		
        return $this->successResponse($this->positionRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		Authority::acl_access(Auth::user(), 'positions');
		
		Authority::check('update');
		
		return $this->successResponse($this->positionRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::acl_access(Auth::user(), 'positions');
		
		Authority::check('delete');
		
        return $this->successResponse($this->positionRepository->delete($id), 200); 
	}
}