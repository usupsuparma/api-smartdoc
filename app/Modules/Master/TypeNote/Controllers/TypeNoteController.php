<?php namespace App\Modules\Master\TypeNote\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Master\TypeNote\Models\TypeNoteModel;
use App\Modules\Master\TypeNote\Repositories\TypeNoteRepositories;
use Authority, Auth;

class TypeNoteController extends BaseController 
{
	private $typeNoteRepository;
	
	public function __construct(TypeNoteRepositories $typeNoteRepository) 
	{
		$this->typeNoteRepository = $typeNoteRepository;
		Authority::acl_access(Auth::user(), 'type_notes');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->typeNoteRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->showOne(TypeNoteModel::findOrFail($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
        return $this->successResponse($this->typeNoteRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->typeNoteRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->typeNoteRepository->delete($id), 200); 
    }
}