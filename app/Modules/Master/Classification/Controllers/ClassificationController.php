<?php namespace App\Modules\Master\Classification\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Master\Classification\Models\ClassificationModel;
use App\Modules\Master\Classification\Repositories\ClassificationRepositories;
use Authority, Auth;

class ClassificationController extends BaseController 
{
	private $classificationRepository;
	
	public function __construct(ClassificationRepositories $classificationRepository) 
	{
		$this->classificationRepository = $classificationRepository;
		Authority::acl_access(Auth::user(), 'classification');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->classificationRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->showOne(ClassificationModel::findOrFail($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
        return $this->successResponse($this->classificationRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->classificationRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->classificationRepository->delete($id), 200); 
    }
}