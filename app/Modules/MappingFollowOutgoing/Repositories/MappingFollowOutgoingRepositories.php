<?php namespace App\Modules\MappingFollowOutgoing\Repositories;
/**
 * Class MappingFollowOutgoingRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\MappingFollowOutgoing\Interfaces\MappingFollowOutgoingInterface;
use App\Modules\MappingFollowOutgoing\Models\MappingFollowOutgoingModel;
use Validator;

class MappingFollowOutgoingRepositories extends BaseRepository implements MappingFollowOutgoingInterface
{
	public function model()
	{
		return MappingFollowOutgoingModel::class;
	}
	
    public function data($request)
    {	
		return $this->model->get();
	}
	public function create($request)
    {
		$rules = [
			'type_id' => 'required|unique:mapping_follow_outgoing,type_id,NULL,id,deleted_at,NULL'
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
