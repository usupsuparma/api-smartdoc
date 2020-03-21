<?php namespace App\Modules\Master\Type\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Master\Type\Models\TypeModel;
use App\Modules\Master\Type\Repositories\TypeRepositories;
use Authority, Auth;

class TypeController extends BaseController 
{
	private $typeRepository;
	
	public function __construct(TypeRepositories $typeRepository) 
	{
		$this->typeRepository = $typeRepository;
		Authority::acl_access(Auth::user(), 'type');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->typeRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->showOne(TypeModel::findOrFail($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
        return $this->successResponse($this->typeRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->typeRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->typeRepository->delete($id), 200); 
	}
	
	public function select_type()
	{
		return $this->successResponse($this->typeRepository->select_type(),200);
	}
}