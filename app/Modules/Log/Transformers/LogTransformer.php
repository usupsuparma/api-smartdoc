<?php namespace App\Modules\Log\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class LogTransformer extends TransformerAbstract
{
	/** 
	 * User Transformer
	 * @return array
	 */
	
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'user_id' => $data->user_id,
			'model' => (string) $data->model,
			'type' => (string) $data->type,
			'activity' => (string) $data->activity,
			'visitor' => (string) $data->visitor,
			'created_at' => $data->created_at->format('d-m-Y'),
		];
	 }
}