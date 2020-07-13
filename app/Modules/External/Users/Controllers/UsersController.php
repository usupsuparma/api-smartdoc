<?php namespace App\Modules\External\Users\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\External\Users\Repositories\UsersRepositories;
use Authority, Auth;

class UsersController extends BaseController 
{
	private $usersRepository;
	
	public function __construct(UsersRepositories $usersRepository) 
	{
		$this->usersRepository = $usersRepository;
	}
	
	public function create(Request $request)
	{
		return $this->successResponse($this->usersRepository->create($request),200);
	}
	
	public function update(Request $request, $id)
	{
		return $this->successResponse($this->usersRepository->update($request, $id),200);
	}
	
	public function delete($id)
	{
		// return $this->successResponse($this->dispositionFollowRepository->show($id),200);
	}
}