<?php namespace App\Modules\SpecialDivisionOutgoing\Repositories;
/**
 * Class SpecialDivisionOutgoingRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\SpecialDivisionOutgoing\Interfaces\SpecialDivisionOutgoingInterface;
use App\Modules\SpecialDivisionOutgoing\Models\SpecialDivisionOutgoingModel;
use Validator;

class SpecialDivisionOutgoingRepositories extends BaseRepository implements SpecialDivisionOutgoingInterface
{
	public function model()
	{
		return SpecialDivisionOutgoingModel::class;
	}
	
    public function data($request)
    {	
		return $this->model->get();
	}
	public function create($request)
    {
		$rules = [
			'structure_id' => 'required|unique:special_division_outgoing,structure_id,NULL,id,deleted_at,NULL'
		];
		
		Validator::validate($request->all(), $rules);
		
		$model = $this->model->create($request->all());

		created_log($model);
		
		return ['message' => config('constans.success.created')];
	}
	
	public function delete($id)
    {
		$model = $this->model->findOrFail($id);
		deleted_log($model);
		$model->delete();

		return ['message' => config('constans.success.deleted')];
	}
}
