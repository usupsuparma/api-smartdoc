<?php namespace App\Modules\External\Position\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\External\Position\Repositories\PositionRepositories;

class PositionController extends BaseController 
{
	private $positionRepository;
	
	public function __construct(PositionRepositories $positionRepository) 
	{
		$this->positionRepository = $positionRepository;
	}
	
	public function options()
	{
		return $this->successResponse($this->positionRepository->options(),200);
	}
}