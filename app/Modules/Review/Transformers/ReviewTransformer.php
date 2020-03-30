<?php namespace App\Modules\Review\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class ReviewTransformer extends TransformerAbstract
{
	/** 
	 * Review Transformer
	 * @return array
	 */
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'name' => (string) $data->name,
			'code' => (string) $data->code,
			'status' => (int) $data->status,
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	 }
}