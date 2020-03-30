<?php namespace App\Modules\External\Organization\Repositories;
/**
 * Class OrganizationRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\External\Organization\Interfaces\OrganizationInterface;
use App\Modules\External\Organization\Models\OrganizationModel;
use Validator;

class OrganizationRepositories extends BaseRepository implements OrganizationInterface
{
	public function model()
	{
		return OrganizationModel::class;
	}
	
	public function options()
	{
		return ['data' => $this->model->options()];
	}
}
