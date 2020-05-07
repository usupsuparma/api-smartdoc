<?php namespace App\Modules\MappingStructure\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\MappingStructure\Repositories\MappingStructureRepositories;
use Authority, Auth;

class MappingStructureController extends BaseController 
{
	private $mappingStructureRepository;
	
	public function __construct(MappingStructureRepositories $mappingStructureRepository) 
	{
		$this->mappingStructureRepository = $mappingStructureRepository;
		Authority::acl_access(Auth::user(), 'mapping-structure');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->mappingStructureRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->successResponse($this->mappingStructureRepository->show($id),200);
	}
	
	public function update(Request $request, $id)
	{
		Authority::check('update');
		
		$results = $this->mappingStructureRepository->update($request, $id);
		
		if (!$results['status']) {
			return $this->errorResponse($results['message'], 404);
		}
		
        return $this->successResponse($results, 200);
	}
}