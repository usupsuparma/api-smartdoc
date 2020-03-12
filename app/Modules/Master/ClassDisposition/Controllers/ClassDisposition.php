<?php namespace App\Modules\Master\ClassDisposition\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Master\ClassDisposition\Models\ClassDispositionModel;
use App\Modules\Master\ClassDisposition\Repositories\ClassDispositionRepositories;
use Authority, Auth;

class ClassDispositionController extends BaseController 
{
	private $classDispositionRepository;
	
	public function __construct(ClassDispositionRepositories $classDispositionRepository) 
	{
		$this->classDispositionRepository = $classDispositionRepository;
		Authority::acl_access(Auth::user(), 'type');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->classDispositionRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->showOne(ClassDispositionModel::findOrFail($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
        return $this->successResponse($this->classDispositionRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->classDispositionRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->classDispositionRepository->delete($id), 200); 
    }
}