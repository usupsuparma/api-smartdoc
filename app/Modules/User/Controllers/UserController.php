<?php namespace App\Modules\User\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Modules\User\Models\UserModel;
use App\Library\Bases\BaseController;
use App\Modules\User\Repositories\UserRepositories;
use Authority, Auth;

class UserController extends BaseController
{
	private $userRepository;
	
    public function __construct(UserRepositories $userRepository)
    {
		$this->userRepository = $userRepository;
		Authority::acl_access(Auth::user(), 'user');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->userRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->showOne(UserModel::findOrFail($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
        return $this->successResponse($this->userRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->userRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->userRepository->delete($id), 200); 
	}
	
	public function reset_user($id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->userRepository->reset_user($id), 200); 
	}
}
