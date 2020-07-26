<?php namespace App\Modules\Archive\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Archive\Repositories\ArchiveOutgoingRepositories;
use Authority, Auth;

class ArchiveOutgoingController extends BaseController 
{
	private $archiveOutgoingRepository;
	
	public function __construct(ArchiveOutgoingRepositories $archiveOutgoingRepository) 
	{
		$this->archiveOutgoingRepository = $archiveOutgoingRepository;
		Authority::acl_access(Auth::user(), 'archive-outgoings');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->archiveOutgoingRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->successResponse($this->archiveOutgoingRepository->show($id),200);
	}
}