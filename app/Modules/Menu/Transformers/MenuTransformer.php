<?php namespace App\Modules\Menu\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class MenuTransformer extends TransformerAbstract
{
	/** 
	 * Menu Transformer
	 * @return array
	 */
	
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'parent_id' => $data->parent_id > 0 ? (int) $data->parent_id : null,
			'name' => (string) $data->name,
			'url' => (string) $data->url,
			'function' => (string) $data->function,
			'component' => !is_null($data->component) ? (string) $data->component : null,
			'show' => $data->show,
			'icon' => (string) $data->icon,
		];
	 }
}