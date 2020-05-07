<?php namespace App\Modules\MappingStructure\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class MappingStructureTransformer extends TransformerAbstract
{
	/** 
	 * Review Transformer
	 * @return array
	 */
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'name' => $data->name,
			'code' => $data->code,
			'primary' => [
				'id' => !empty($data->primary->id) ? $data->primary->id : null,
				'name' => !empty($data->primary->nama_jabatan) ? $data->primary->nama_jabatan : null,
			],
			'secondary' => [
				'id' => !empty($data->secondary->id) ? $data->secondary->id : null,
				'name' => !empty($data->secondary->nama_jabatan) ? $data->secondary->nama_jabatan : null,
			],
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	}
	 
	/** 
	 * Custom Transformer
	 * @return array
	 */
	public static function customTransform($data) 
	{
		$structures = [];
		
		if (!empty($data->details)) {
			foreach ($data->details as $item) {
				$structures[] = [
					'id' => $item->id,
					'name' => $item->nama_struktur,
					'code' => $item->kode_struktur
				];
			}
		}
		
	    return [
			'id' => (int) $data->id,
			'name' => $data->name,
			'code' => $data->code,
			'primary' => [
				'id' => !empty($data->primary->id) ? $data->primary->id : null,
				'name' => !empty($data->primary->nama_jabatan) ? $data->primary->nama_jabatan : null,
			],
			'secondary' => [
				'id' => !empty($data->secondary->id) ? $data->secondary->id : null,
				'name' => !empty($data->secondary->nama_jabatan) ? $data->secondary->nama_jabatan : null,
			],
			'structure' => $structures,
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
	   ];
	}
}