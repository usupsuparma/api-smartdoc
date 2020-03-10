<?php namespace App\Modules\Role\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Modules\Role\Models\RoleModel;
use App\Library\Bases\BaseController;
use App\Modules\Role\Repositories\RoleRepositories;
class RoleController extends BaseController
{
	private $roleRepository;
	
    public function __construct(RoleRepositories $roleRepository)
    {
        $this->roleRepository = $roleRepository;
	}
	
	public function data(Request $request)
	{
		return $this->showAll($this->roleRepository->data($request),200);
	}
	
	public function show($id)
	{
		return $this->showOne(RoleModel::findOrFail($id),200);
	}
	
	public function show_menu(Request $request)
	{
		return $this->successResponse(['data' => $this->roleRepository->showMenu($request)],200);
	}
	
	public function create(Request $request)
	{
        return $this->successResponse($this->roleRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		return $this->successResponse($this->roleRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
        return $this->successResponse($this->roleRepository->delete($id), 200); 
    }
}
