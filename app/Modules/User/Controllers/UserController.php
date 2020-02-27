<?php namespace App\Modules\User\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Modules\User\Models\UserModel;
use App\Library\Bases\BaseController;
use App\Modules\User\Repositories\UserRepositories;
use Auth;
class UserController extends BaseController
{
	private $userRepository;
	
    public function __construct(UserRepositories $userRepository)
    {
        $this->userRepository = $userRepository;
	}
	
	public function data(Request $request)
	{
		return $this->showAll($this->userRepository->data($request),200);
	}
	
	public function show($id)
	{
		return $this->showOne(UserModel::findOrFail($id),200);
	}
	
	public function create(Request $request)
	{
        return $this->successResponse($this->userRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		return $this->successResponse($this->userRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
        $this->successResponse($this->userRepository->delete($id), 200); 
    }
}
