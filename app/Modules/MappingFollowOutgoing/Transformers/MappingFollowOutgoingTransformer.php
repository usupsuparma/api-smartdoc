<?php namespace App\Modules\MappingFollowOutgoing\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class MappingFollowOutgoingTransformer extends TransformerAbstract
{
	/** 
	 * ClassDisposition Transformer
	 * @return array
	 */
	
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'type' => [
				'id' => !empty($data->type->id) ? $data->type->id : NULL,
				'name' => !empty($data->type->name) ? $data->type->name : NULL,
			],
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	 }
}