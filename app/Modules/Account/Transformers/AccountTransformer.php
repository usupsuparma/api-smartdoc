<?php namespace App\Modules\Account\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class AccountTransformer extends TransformerAbstract
{
	/** 
	 * Type Transformer
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
		];
	 }
}