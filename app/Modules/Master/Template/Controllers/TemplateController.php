<?php namespace App\Modules\Master\Template\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Master\Template\Models\TemplateModel;
use App\Modules\Master\Template\Repositories\TemplateRepositories;
use Authority, Auth;

class TemplateController extends BaseController 
{
	private $templateRepository;
	
	public function __construct(TemplateRepositories $templateRepository) 
	{
		$this->templateRepository = $templateRepository;
		Authority::acl_access(Auth::user(), 'template');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->templateRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->showOne(TemplateModel::findOrFail($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
        return $this->successResponse($this->templateRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->templateRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->templateRepository->delete($id), 200); 
    }
}