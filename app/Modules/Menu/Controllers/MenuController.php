<?php namespace App\Modules\Menu\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Modules\Menu\Models\MenuModel;
use App\Library\Bases\BaseController;
use App\Modules\Menu\Repositories\MenuRepositories;
use Authority, Auth;

class MenuController extends BaseController
{
	private $menuRepository;
	
    public function __construct(MenuRepositories $menuRepository)
    {
		$this->menuRepository = $menuRepository;
		Authority::acl_access(Auth::user(), 'menu');
	}
	
	public function data(Request $request)
	{	
		Authority::check('read');
		
		return $this->showAll($this->menuRepository->data($request), 200, false);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->showOne(MenuModel::findOrFail($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
        return $this->successResponse($this->menuRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->menuRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->menuRepository->delete($id), 200); 
	}
	
	public function ordering(Request $request)
	{
		Authority::check('update');
		
        return $this->successResponse($this->menuRepository->ordering($request), 200); 
	}
}
