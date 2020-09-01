<?php namespace App\Modules\External\ExternalUser\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class ExternalUserTransformer extends TransformerAbstract
{
	/** 
	 * ExternalUser Transformer
	 * @return array
	 */
	
	public function transform($data) 
	{
		return [
			'id' => (int) $data->user_id,
			'employee' => [
				'id' => (int) $data->employee->id_employee,
				'name' => (string) $data->employee->name,
				'nik' => (string) $data->employee->nik,
			],
			'structure' => [
				'id' => (int) $data->structure->id,
				'name' => (string) $data->structure->nama_struktur,
				'code' => (string) $data->structure->kode_struktur,
			],
			'position' => [
				'id' => (int) $data->position->id,
				'name' => (string) $data->position->nama_jabatan
			],
			'status' => $data->status,
		];
	}
}