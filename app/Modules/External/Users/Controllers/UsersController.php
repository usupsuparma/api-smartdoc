<?php namespace App\Modules\External\Users\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\External\Users\Repositories\DispositionFollowRepositories;
use Authority, Auth;

class UsersController extends BaseController 
{
	private $dispositionFollowRepository;
	
	// public function __construct(DispositionFollowRepositories $dispositionFollowRepository) 
	// {
	// 	$this->dispositionFollowRepository = $dispositionFollowRepository;
	// 	Authority::acl_access(Auth::user(), 'dispositions-follow');
	// }
	
	public function create(Request $request)
	{
		dd('create');
		// Authority::check('read');
		
		// return $this->showAll($this->dispositionFollowRepository->data($request),200);
	}
	
	public function update(Request $request, $id)
	{
		dd('update');
		// Authority::check('read');
		
		// return $this->showAll($this->dispositionFollowRepository->data($request),200);
	}
	
	public function delete($id)
	{
		dd('delete');
		// return $this->successResponse($this->dispositionFollowRepository->show($id),200);
	}
}