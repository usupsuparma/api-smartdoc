<?php namespace App\Modules\Report\Disposition\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Report\Disposition\Repositories\ReportDispositionRepositories;
use Authority, Auth;

class ReportDispositionController extends BaseController 
{
	private $reportDispositionRepository;
	
	public function __construct(ReportDispositionRepositories $reportDispositionRepositories)
	{
		$this->reportDispositionRepository = $reportDispositionRepositories;
		Authority::acl_access(Auth::user(), 'report-disposition');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->reportDispositionRepository->data($request), 200);
	}
	
	public function export_data(Request $request)
	{
		Authority::check('export');
		
		return $this->reportDispositionRepository->export_data($request);
	}
}