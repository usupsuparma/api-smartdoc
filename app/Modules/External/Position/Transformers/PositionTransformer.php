<?php namespace App\Modules\External\Position\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class PositionTransformer extends TransformerAbstract
{
	/** 
	 * Position Transformer
	 * @return array
	 */
	
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'nama_jabatan' => (string) $data->nama_jabatan,
			'status' => $data->status,
		];
	 }
}