<?php namespace App\Modules\Setting\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class SettingTransformer extends TransformerAbstract
{
	/** 
	 * Setting Transformer
	 * @return array
	 */
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'name' => (string) $data->name,
			'code' => (string) $data->code,
			'value' => (string) $data->value,
			'description' => (string) $data->description,
			'status' => (int) $data->status,
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	 }
}