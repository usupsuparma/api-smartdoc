<?php namespace App\Modules\External\Employee\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\External\Employee\Repositories\EmployeeRepositories;
use Authority, Auth;

class EmployeeController extends BaseController 
{
	private $employeeRepository;
	
	public function __construct(EmployeeRepositories $employeeRepository) 
	{
		$this->employeeRepository = $employeeRepository;
	}
	
	public function options()
	{
		return $this->successResponse($this->employeeRepository->options(),200);
	}
}