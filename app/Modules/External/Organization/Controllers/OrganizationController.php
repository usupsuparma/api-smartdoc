<?php namespace App\Modules\External\Organization\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\External\Organization\Models\OrganizationModel;
use App\Modules\External\Organization\Repositories\OrganizationRepositories;
use Authority, Auth;

class OrganizationController extends BaseController 
{
	private $organizationRepository;
	
	public function __construct(OrganizationRepositories $organizationRepository) 
	{
		$this->organizationRepository = $organizationRepository;
	}
	
	public function options()
	{
		return $this->successResponse($this->organizationRepository->options(),200);
	}
	
	public function option_disposition($incoming_mail_id)
	{
		return $this->successResponse($this->organizationRepository->option_disposition($incoming_mail_id),200);
	}
}