<?php namespace App\Modules\Menu\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Library\Bases\BaseController;
use App\Modules\Menu\Repositories\MenuRepositories;

class SideMenuController extends BaseController
{
	private $menuRepository;
	
    public function __construct(MenuRepositories $menuRepository)
    {
		$this->menuRepository = $menuRepository;
	}
	
	public function navigation()
	{
        return $this->successResponse(['data' => $this->menuRepository->navigation()], 200, false);
	}
}