<?php namespace App\Modules\Role\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Modules\Role\Models\RoleModel;
use App\Library\Bases\BaseController;
use App\Modules\Role\Repositories\RoleRepositories;
use Authority, Auth;

class RoleController extends BaseController
{
	private $roleRepository;
	
    public function __construct(RoleRepositories $roleRepository)
    {
		$this->roleRepository = $roleRepository;
		Authority::acl_access(Auth::user(), 'role');
		
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->roleRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->showOne(RoleModel::findOrFail($id),200);
	}
	
	public function show_menu(Request $request)
	{
		Authority::check('read');
		
		return $this->successResponse(['data' => $this->roleRepository->showMenu($request)],200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
        return $this->successResponse($this->roleRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->roleRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->roleRepository->delete($id), 200); 
    }
}
