<?php namespace App\Modules\External\Organization\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class OrganizationTransformer extends TransformerAbstract
{
	/** 
	 * Organization Transformer
	 * @return array
	 */
	
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'parent_id' => $data->parent_id,
			'nama_struktur' => (string) $data->nama_struktur,
			'kode_struktur' => (int) $data->kode_struktur,
			'order' => (int) $data->order,
			'status' => $data->status,
		];
	 }
}