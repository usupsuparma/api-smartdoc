<?php namespace App\Modules\Archive\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Archive\Repositories\ArchiveIncomingRepositories;
use Authority, Auth;

class ArchiveIncomingController extends BaseController 
{
	private $archiveIncomingRepository;
	
	public function __construct(ArchiveIncomingRepositories $archiveIncomingRepository) 
	{
		$this->archiveIncomingRepository = $archiveIncomingRepository;
		// Authority::acl_access(Auth::user(), 'archive-incomings');
	}
	
	public function data(Request $request)
	{
		// Authority::check('read');
		
		return $this->showAll($this->archiveIncomingRepository->data($request),200);
	}
	
	public function show($id)
	{
		// Authority::check('read');
		
		return $this->successResponse($this->archiveIncomingRepository->show($id),200);
	}
}