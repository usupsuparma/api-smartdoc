<?php namespace App\Modules\Report\Outgoing\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Report\Outgoing\Repositories\ReportOutgoingRepositories;
use Authority, Auth;
use App\Helpers\BearerToken;

class ReportOutgoingController extends BaseController 
{
	private $reportOutgoingRepository;
	
	public function __construct(ReportOutgoingRepositories $reportOutgoingRepositories)
	{
		$this->reportOutgoingRepository = $reportOutgoingRepositories;
	}
	
	public function data(Request $request)
	{
		Authority::acl_access(Auth::user(), 'report-outgoing');
		Authority::check('read');
		
		return $this->showAll($this->reportOutgoingRepository->data($request), 200);
	}
	
	public function export_data(Request $request)
	{
		$token = BearerToken::get_token($request);
		
		if ($token === $request->get('token')) {
			return $this->reportOutgoingRepository->export_data($request);
		}
	}
}