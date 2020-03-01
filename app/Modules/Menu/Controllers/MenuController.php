<?php namespace App\Modules\Menu\Controllers;

use Illuminate\Http\Request;
use App\Modules\Menu\Models\MenuModel;
use App\Library\Bases\BaseController;
use App\Modules\Menu\Repositories\MenuRepositories;

class MenuController extends BaseController
{
	private $menuRepository;
	
    public function __construct(MenuRepositories $menuRepository)
    {
        $this->menuRepository = $menuRepository;
	}
	
	public function data(Request $request)
	{
		return $this->showAll($this->menuRepository->data($request),200);
	}
	
	public function show($id)
	{
		return $this->showOne(MenuModel::findOrFail($id),200);
	}
	
	public function create(Request $request)
	{
        return $this->successResponse($this->menuRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		return $this->successResponse($this->menuRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
        return $this->successResponse($this->menuRepository->delete($id), 200); 
    }
}
