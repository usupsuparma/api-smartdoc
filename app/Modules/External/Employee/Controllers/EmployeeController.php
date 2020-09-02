<?php namespace App\Modules\External\Employee\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\External\Employee\Repositories\EmployeeRepositories;
use Authority, Auth;

class EmployeeController extends BaseController 
{
	private $employeeRepository;
	
	public function __construct(EmployeeRepositories $employeeRepository) 
	{
		$this->employeeRepository = $employeeRepository;
	}
	
	public function options()
	{
		return $this->successResponse($this->employeeRepository->options(),200);
	}
	
	public function option_hierarchy()
	{
		return $this->successResponse($this->employeeRepository->option_hierarchy(),200);
	}
	
	public function option_structure($id)
	{
		return $this->successResponse($this->employeeRepository->option_structure($id),200);
	}
	
	public function data(Request $request)
	{
		Authority::acl_access(Auth::user(), 'employees');
		
		Authority::check('read');
		
		return $this->showAll($this->employeeRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::acl_access(Auth::user(), 'employees');
		
		Authority::check('read');
		
		return $this->showOne($this->employeeRepository->show($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::acl_access(Auth::user(), 'employees');
		
		Authority::check('create');
		
        return $this->successResponse($this->employeeRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		Authority::acl_access(Auth::user(), 'employees');
		
		Authority::check('update');
		
		return $this->successResponse($this->employeeRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::acl_access(Auth::user(), 'employees');
		
		Authority::check('delete');
		
        return $this->successResponse($this->employeeRepository->delete($id), 200); 
	}
}