<?php namespace App\Modules\Test\Transformers;

use League\Fractal\TransformerAbstract;
class TestTransformer extends TransformerAbstract
{
	/** 
	 * Test Transformer
	 * @return array
	 */
	
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'name' => (string) $data->name,
			'email' => (string) $data->email,
			'description' => (string) $data->description,
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y'),
			'deleted_at' => is_null($data->deleted_at)  ? '' : $data->deleted_at->format('d-m-Y'),
		];
	 }
}