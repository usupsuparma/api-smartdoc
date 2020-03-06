<?php namespace App\Traits;
/**
 * @author Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com> 
 */

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Validator;

trait ApiResponse 
{
	/**
	 * @param array   $data Data collection.
	 * @param integer $code Response code.
	 * @return mixed
	 */
	protected function successResponse($data, $code) 
	{
		return response()->json($data, $code);
	}
	
	/**
	 * @param mixed   $message Message.
	 * @param integer $code Response code.
	 * @return mixed
	 */
	protected function errorResponse($message, $code)
	{
		return $this->successResponse(['error' => $message, 'code' => $code], $code);
	}
	
	/**
	 * @param mixed   $collection Data collection.
	 * @param integer $code Response code.
	 * @return mixed
	 */
	protected function showAll(Collection $collection, $code = 200, $paginate = true)
	{
		if ($collection->isEmpty()) {
			return $this->successResponse(['data' => $collection], $code);
		}
		
		$transformer = $collection->first()->transformer;
		
		$collection = $this->sortData($collection);
		
		if ($paginate) {
			$collection = $this->paginated($collection);
		}
		
		$collection = $this->transformerData($collection, $transformer);
		
		return $this->successResponse($collection, $code);
	}
	
	/**
	 * @param mixed   $data Data FindbyId.
	 * @param integer $code  Response code.
	 * @return mixed
	 */
	protected function showOne($data, $code = 200)
	{
		$transformer = $data->transformer;
		$data = $this->transformerData($data, $transformer);
		
		return $this->successResponse($data, $code);
	}
	
	/**
	 * @param mixed   $message Message.
	 * @param integer $code Response code.
	 * @return mixed
	 */
	protected function showMessage($message, $code)
	{
		return $this->successResponse(['data' => $message], $code);
	}
	
	protected function sortData(Collection $collection)
	{	
		if (app('request')->has('sort_by')) {
			$attribute = app('request')->sort_by;
			
			$collection = $collection->sortBy($attribute);
		}
		
		return $collection;
	}
	
	/**
	 * @param mixed  $collection Collection.
	 * @return mixed
	 */
	public function paginated(Collection $collection) 
	{
		$rules = [
			'per_page' => 'integer|min:10|max:50'
		];
		
		Validator::validate(app('request')->all(), $rules);
		
		$per_page = 15;
		$page = LengthAwarePaginator::resolveCurrentPage();
		
		if (app('request')->has('per_page') && !empty(app('request')->per_page)) {
			$per_page = (int) app('request')->per_page;
		}
		
		$results = $collection->slice(($page - 1) * $per_page, $per_page)->values();
		$paginated = new LengthAwarePaginator($results, $collection->count(), $per_page, Paginator::resolveCurrentPage(), [
			'path' => Paginator::resolveCurrentPath()
		]);
		
		$paginated->appends(app('request')->all());
		
		return $paginated;
	}

	/**
	 * @param mixed  $collection Collection.
	 * @param mixed  $transformer Class Transformer.
	 * @return mixed
	 */
	protected function transformerData($data, $transformer)
	{
		$transformation = fractal($data, new $transformer);
		
        return $transformation->toArray();
	}
}