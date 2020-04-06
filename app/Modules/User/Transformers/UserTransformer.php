<?php namespace App\Modules\User\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
	/** 
	 * User Transformer
	 * @return array
	 */
	
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'employee' => !empty($data->user_core->employee) ? $data->user_core->employee : NULL,
			'structure' => !empty($data->user_core->structure) ? $data->user_core->structure : NULL,
			'position' => !empty($data->user_core->position) ? $data->user_core->position : NULL,
			'role' => !empty($data->role) ? $data->role : NULL,
			'username' => (string) $data->username,
			'email' => (string) $data->email,
			'status' => (int) $data->status,
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	 }
}