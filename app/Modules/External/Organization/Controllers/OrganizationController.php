<?php namespace App\Modules\External\Organization\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\External\Organization\Repositories\OrganizationRepositories;
use Authority, Auth;

class OrganizationController extends BaseController 
{
	private $organizationRepository;
	
	public function __construct(OrganizationRepositories $organizationRepository) 
	{
		$this->organizationRepository = $organizationRepository;
	}
	
	public function options()
	{
		return $this->successResponse($this->organizationRepository->options(),200);
	}
	
	public function option_disposition()
	{
		return $this->successResponse($this->organizationRepository->option_disposition(),200);
	}
	
	public function data(Request $request)
	{	
		// Authority::acl_access(Auth::user(), 'menu');
		
		// Authority::check('read');
		
		return $this->showAll($this->organizationRepository->data($request), 200, false);
	}
	
	public function show($id)
	{
		// Authority::acl_access(Auth::user(), 'menu');
		
		// Authority::check('read');
		
		return $this->showOne($this->organizationRepository->show($id),200);
	}
	
	public function create(Request $request)
	{
		// Authority::acl_access(Auth::user(), 'menu');
		
		// Authority::check('create');
		
        return $this->successResponse($this->organizationRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		// Authority::acl_access(Auth::user(), 'menu');
		
		// Authority::check('update');
		
		return $this->successResponse($this->organizationRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		// Authority::acl_access(Auth::user(), 'menu');
		
		// Authority::check('delete');
		
        return $this->successResponse($this->organizationRepository->delete($id), 200); 
	}
	
	public function ordering(Request $request)
	{
		// Authority::acl_access(Auth::user(), 'menu');
		
		// Authority::check('update');
		
        return $this->successResponse($this->organizationRepository->ordering($request), 200); 
	}
}