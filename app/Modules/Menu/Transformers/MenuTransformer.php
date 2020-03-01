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
			'parent_id' => (int) $data->parent_id,
			'name' => (string) $data->name,
			'url' => (string) $data->url,
			'icon' => (string) $data->icon,
		];
	 }
}