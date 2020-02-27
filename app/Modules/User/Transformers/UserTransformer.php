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
			'employee_id' => $data->employee_id,
			'role_id' => $data->role_id,
			'username' => (string) $data->username,
			'email' => (string) $data->email,
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	 }
}