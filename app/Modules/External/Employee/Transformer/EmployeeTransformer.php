<?php namespace App\Modules\External\Employee\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class EmployeeTransformer extends TransformerAbstract
{
	/** 
	 * Employee Transformer
	 * @return array
	 */
	
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'nik' => (string) $data->nik,
			'name' => (int) $data->name,
		];
	 }
}