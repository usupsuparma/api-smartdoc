<?php namespace App\Modules\Sync\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class SyncTransformer extends TransformerAbstract
{
	/** 
	 * Setting Transformer
	 * @return array
	 */
	 public function transform($data) 
	 {
		
		return [
			'id' => (int) $data->id,
			'employee' => [
				'name' => isset($data->user->user_core) ? $data->user->user_core->employee->name : 'Superadmin SmartDoc'
			],
			'description' => $data->description,
			'last_sync' => $data->created_at->format('Y-m-d H:i:s')
		];
	 }
}