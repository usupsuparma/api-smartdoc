<?php namespace App\Modules\External\Employee\Repositories;
/**
 * Class EmployeeRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\External\Employee\Interfaces\EmployeeInterface;
use App\Modules\External\Employee\Models\EmployeeModel;
use Validator;

class EmployeeRepositories extends BaseRepository implements EmployeeInterface
{
	public function model()
	{
		return EmployeeModel::class;
	}
	
	public function options()
	{
		return ['data' => $this->model->options()];
	}
}
