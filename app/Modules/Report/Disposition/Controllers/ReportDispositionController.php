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
	}
	
	public function data(Request $request)
	{
		return $this->showAll($this->reportDispositionRepository->data($request), 200);
	}
	
	public function export_data(Request $request)
	{
		return $this->successResponse($this->reportDispositionRepository->export_data($request), 200);
	}
}