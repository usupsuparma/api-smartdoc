<?php namespace App\Modules\MappingStructure\Repositories;
/**
 * Class MappingStructureRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\MappingStructure\Interfaces\MappingStructureInterface;
use App\Modules\MappingStructure\Models\MappingStructureModel;
use App\Modules\MappingStructure\Transformers\MappingStructureTransformer;
use Validator;

class MappingStructureRepositories extends BaseRepository implements MappingStructureInterface
{
	public function model()
	{
		return MappingStructureModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->isActive();
		
		return $query->get();
	}
	
	public function show($id)
    {
		$data =  $this->model->findOrFail($id);
		
		return ['data' => MappingStructureTransformer::customTransform($data)];
	}
	
	public function update($request, $id)
    {
		$model = $this->model->findOrFail($id);
		
		$rules = [
			'primary_top_level_id' => 'required',
			'structures' => 'present|array',
    		'structures.*' => 'filled'
		];
		
		$message = [
			'primary_top_level_id.required' => 'Primary top level wajib diisi',
		];
		
		Validator::validate($request->all(), $rules, $message);
		
		$model->update([
			'primary_top_level_id' => !empty($request->primary_top_level_id) ? $request->primary_top_level_id : NULL,
			'secondary_top_level_id' => !empty($request->secondary_top_level_id) ?  $request->secondary_top_level_id : NULL
		]);
		
		$model->details()->sync($request->structures);
		
		updated_log($model);
		
		return [
			'message' => config('constans.success.created'), 
			'status' => true
		];
	} 
}
