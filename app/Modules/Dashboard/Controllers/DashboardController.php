<?php namespace App\Modules\Dashboard\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Dashboard\Repositories\DashboardRepositories;

class DashboardController extends BaseController
{
	private $dashboardRepository;
	
	public function __construct(DashboardRepositories $dashboardRepository) {
		$this->dashboardRepository = $dashboardRepository;
	}
	
	public function get_count_all_mail(Request $request)
	{
		return $this->successResponse($this->dashboardRepository->get_count_all_mail($request), 200);
	}
}