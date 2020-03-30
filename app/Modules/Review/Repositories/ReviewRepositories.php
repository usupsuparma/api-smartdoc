<?php namespace App\Modules\Review\Repositories;
/**
 * Class ReviewRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Review\Interfaces\ReviewInterface;
use App\Modules\Review\Models\ReviewModel;
use App\Modules\Review\Models\ReviewDetailModel;
use Validator;

class ReviewRepositories extends BaseRepository implements ReviewInterface
{
	public function model()
	{
		return ReviewModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->where('status', $request->status);
		
		if ($request->has('name') && !empty($request->name)) {
			$query->where('name', 'like', "%{$request->name}%");
			$query->orWhere('code', 'like', "%{$request->name}%");
		}
		
		return $query->get();
	}
	
	public function show($id)
    {
        return $this->model->findOrFail($id);
	}
	
	public function data_detail($request, $id)
    {
		return ReviewDetailModel::ByReview($id);
	}
	
	public function show_detail($id)
    {
        return ReviewDetailModel::findOrFail($id);
	}
	
	public function create_detail($request, $review_id)
    {
		Validator::extend('duplicate_structure', function ($attribute, $value, $parameters) use ($request, $review_id) {
			if (!empty($request->structure_id)) {
				$query = ReviewDetailModel::where([
					'review_id' => $review_id,
					'structure_id' => $request->structure_id
				]);
				
				if ($query->count() > 0) {
						return false;
				}
				
				return true;
			}
			
            return true;
        });
		
		$rules = [
			'structure_id' => 'required|duplicate_structure',
		];
		
		$message = [
			'structure_id.required' => 'Struktur wajib diisi.',
			'structure_id.duplicate_structure' => 'Struktur sudah ada.',
		];
		
		Validator::validate($request->all(), $rules, $message);
		
		$checkOrder = ReviewDetailModel::CheckOrder($review_id);
		
		$model = ReviewDetailModel::create($request->merge([
			'review_id' => $review_id,
			'order' => $checkOrder->count() + 1,
		])->all());

		created_log($model);
		
		return ['message' => config('constans.success.created')];
	}
	
	public function update_detail($request, $id)
    {
		Validator::extend('duplicate_structure', function ($attribute, $value, $parameters) use ($request, $id) {
			if (!empty($request->structure_id)) {
				$query = ReviewDetailModel::where([
					'review_id' => $request->review_id,
					'structure_id' => $request->structure_id
				]);
				
				if ($query->count() > 0) {
					if (empty($id) || $query->first()->id != $id) {
						return false;
					}
				}
				
				return true;
			}
			
			return true;
		});
		
		$rules = [
			'structure_id' => 'required|duplicate_structure',
		];
		
		$message = [
			'structure_id.required' => 'Struktur wajib diisi.',
			'structure_id.duplicate_structure' => 'Struktur sudah ada.',
		];
		
		Validator::validate($request->all(), $rules, $message);
		
		$model = ReviewDetailModel::findOrFail($id);
		
		$model->update($request->merge([
			'order' => $model->order
		])->all());
		
		updated_log($model);
		
		return ['message' => config('constans.success.updated')];
	}
	
	public function delete_detail($id)
    {
		$model = ReviewDetailModel::findOrFail($id);
		deleted_log($model);
		$model->delete();
		
		return ['message' => config('constans.success.deleted')];
    }
}
