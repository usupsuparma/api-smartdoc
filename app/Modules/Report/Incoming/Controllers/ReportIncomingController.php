<?php namespace App\Modules\Report\Incoming\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Report\Incoming\Repositories\ReportIncomingRepositories;
use Authority, Auth;
use App\Helpers\BearerToken;

class ReportIncomingController extends BaseController 
{
	private $reportIncomingRepository;
	
	public function __construct(ReportIncomingRepositories $reportIncomingRepositories)
	{
		$this->reportIncomingRepository = $reportIncomingRepositories;
	}
	
	public function data(Request $request)
	{
		Authority::acl_access(Auth::user(), 'report-incoming');
		Authority::check('read');
		
		return $this->showAll($this->reportIncomingRepository->data($request), 200);
	}
	
	public function export_data(Request $request)
	{	
		$token = BearerToken::get_token($request);
		
		if ($request->has('token') && $token === $request->get('token')) {
			return $this->reportIncomingRepository->export_data($request);
		}
	}
}