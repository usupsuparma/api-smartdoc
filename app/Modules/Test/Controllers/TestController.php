<?php namespace App\Modules\Test\Controllers;

use Illuminate\Http\Request;
use App\Modules\Test\Models\TestModel;
use App\Library\Bases\BaseController;
use App\Modules\Test\Repositories\TestRepositories;

class TestController extends BaseController
{
	private $testRepository;
	
    public function __construct(TestRepositories $testRepository)
    {
        $this->testRepository = $testRepository;
	}
	
	public function data(Request $request)
	{
		return $this->showAll($this->testRepository->data($request),200);
	}
	
	public function show($id)
	{
		return $this->showOne(TestModel::findOrFail($id),200);
	}
	
	public function create(Request $request)
	{
        return $this->successResponse($this->testRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		return $this->successResponse($this->testRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
        $this->successResponse($this->testRepository->delete($id), 200); 
    }
}
