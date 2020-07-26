<?php namespace App\Modules\Archive\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Archive\Repositories\ArchiveDispositionRepositories;
use Authority, Auth;

class ArchiveDispositionController extends BaseController 
{
	private $archiveDispositionRepository;
	
	public function __construct(ArchiveDispositionRepositories $archiveDispositionRepository) 
	{
		$this->archiveDispositionRepository = $archiveDispositionRepository;
		Authority::acl_access(Auth::user(), 'archive-dispositions');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->archiveDispositionRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->successResponse($this->archiveDispositionRepository->show($id),200);
	}
}