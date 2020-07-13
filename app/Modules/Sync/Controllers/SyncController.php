<?php namespace App\Modules\Sync\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Sync\Repositories\SyncRepositories;
use Authority, Auth;

class SyncController extends BaseController 
{
	private $syncRepository;
	
	public function __construct(SyncRepositories $syncRepository) 
	{
		$this->syncRepository = $syncRepository;
		Authority::acl_access(Auth::user(), 'syncs');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->syncRepository->data(),200);
	}
	
	public function create()
	{
		Authority::check('create');
		
        $results = $this->syncRepository->generate_sync();
		
		if (!$results['status']) {
			return $this->errorResponse($results, 500);
		}
		
        return $this->successResponse($results, 200);
	}
	
	public function generate_token_client()
	{
		Authority::check('create');
		
        $results = $this->syncRepository->generate_token_client();
		
		if (isset($results['status']) && !$results['status']) {
			return $this->errorResponse($results, 500);
		}
		
        return $this->successResponse($results, 200);
	}
}