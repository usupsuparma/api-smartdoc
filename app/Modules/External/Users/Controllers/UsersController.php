<?php namespace App\Modules\External\Users\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\External\Users\Repositories\UsersRepositories;
use Authority, Auth;

class UsersController extends BaseController 
{
	private $usersRepository;
	
	public function __construct(UsersRepositories $usersRepository) 
	{
		$this->usersRepository = $usersRepository;
	}
	
	public function create(Request $request)
	{
		return $this->successResponse($this->usersRepository->create($request),200);
	}
	
	public function update(Request $request, $id)
	{
		return $this->successResponse($this->usersRepository->update($request, $id),200);
	}
	
	public function data_ex(Request $request)
	{
		// Authority::acl_access(Auth::user(), 'external-users');
		
		// Authority::check('read');
		
		return $this->showAll($this->usersRepository->data_ex($request),200);
	}
	
	public function show_ex($id)
	{
		// Authority::acl_access(Auth::user(), 'external-users');
		
		// Authority::check('read');
		
		return $this->showOne($this->usersRepository->show_ex($id),200);
	}
	
	public function create_ex(Request $request)
	{
		// Authority::acl_access(Auth::user(), 'external-users');
		
		// Authority::check('create');
		
        return $this->successResponse($this->usersRepository->create_ex($request), 200); 
	}
	
	public function update_ex(Request $request,$id)
    {
		// Authority::acl_access(Auth::user(), 'external-users');
		
		// Authority::check('update');
		
		return $this->successResponse($this->usersRepository->update_ex($request, $id), 200); 
	}
	
	public function delete_ex($id)
    {
		// Authority::acl_access(Auth::user(), 'external-users');
		
		// Authority::check('delete');
		
        return $this->successResponse($this->usersRepository->delete($id), 200); 
	}
}