<?php namespace App\Modules\SpecialDivisionOutgoing\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class SpecialDivisionOutgoingTransformer extends TransformerAbstract
{
	/** 
	 * ClassSpecialDivisionOutgoing Transformer
	 * @return array
	 */
	
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'structure' => [
				'id' => !empty($data->structure->id) ? $data->structure->id : NULL,
				'name' => !empty($data->structure->nama_struktur) ? $data->structure->nama_struktur : NULL,
			],
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	 }
}