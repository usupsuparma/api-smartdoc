<?php namespace App\Modules\Signature\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class SignatureTransformer extends TransformerAbstract
{
	/** 
	 * Setting Transformer
	 * @return array
	 */
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'employee' => !empty($data->employees) ? $data->employees : [],
			'path_to_file' => (string) setting_by_code('FTP_DIRECTORY_ROOT'). $data->path_to_file,
			'status' => (int) $data->status,
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	 }
}