<?php namespace App\Modules\External\Position\Repositories;
/**
 * Class PositionRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\External\Position\Interfaces\PositionInterface;
use App\Modules\External\Position\Models\PositionModel;

class PositionRepositories extends BaseRepository implements PositionInterface
{
	public function model()
	{
		return PositionModel::class;
	}
	
	public function options()
	{
		return ['data' => $this->model->options()];
	}
}
