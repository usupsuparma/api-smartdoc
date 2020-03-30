<?php namespace App\Modules\Review\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class ReviewDetailTransformer extends TransformerAbstract
{
	/** 
	 * Review Transformer
	 * @return array
	 */
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'review' => !empty($data->reviews) ? $data->reviews : [],
			'structure' => !empty($data->organizations) ? $data->organizations : [],
			'order' => (int) $data->order,
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	 }
}