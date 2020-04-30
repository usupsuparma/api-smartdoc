<?php namespace App\Modules\Disposition\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Disposition\Repositories\DispositionFollowRepositories;
use Authority, Auth;

class DispositionFollowController extends BaseController 
{
	private $dispositionFollowRepository;
	
	public function __construct(DispositionFollowRepositories $dispositionFollowRepository) 
	{
		$this->dispositionFollowRepository = $dispositionFollowRepository;
		// Authority::acl_access(Auth::user(), 'dispositions-follow');
	}
	
	public function data(Request $request)
	{
		// Authority::check('read');
		
		return $this->showAll($this->dispositionFollowRepository->data($request),200);
	}
	
	public function show($id)
	{
		// Authority::check('read');
		
		return $this->successResponse($this->dispositionFollowRepository->show($id),200);
	}
	
	public function follow_up(Request $request, $id)
	{
		// Authority::check('create');
		
		$results = $this->dispositionFollowRepository->follow_up($request, $id);
		
		if (!$results['status']) {
			return $this->errorResponse($results['message'], 404);
		}
		
        return $this->successResponse($results, 200);
	}
	
	public function download($id)
    {
		$path = storage_path('app/public'. $this->dispositionFollowRepository->download($id));

		return response()->download($path, basename($path));
	}
}