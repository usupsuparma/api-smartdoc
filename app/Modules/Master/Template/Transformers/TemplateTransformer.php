<?php namespace App\Modules\Master\Template\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class TemplateTransformer extends TransformerAbstract
{
	/** 
	 * Template Transformer
	 * @return array
	 */
	
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'name' => (string) $data->name,
			'type' => !empty($data->type) ? $data->type : '-',
			'template' => (string) $data->template,
			'status' => (int) $data->status,
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	 }
}