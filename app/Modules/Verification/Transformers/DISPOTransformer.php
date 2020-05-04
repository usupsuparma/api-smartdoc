<?php namespace App\Modules\Verification\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class DISPOTransformer extends TransformerAbstract
{
	/** 
	 * Disposition Transformer Custom
	 * @return array
	 */
	public static function customTransform($data) 
	{
	   	$data_assigns = [];
	   
	   	if (!empty($data->assign)) {
			foreach ($data->assign as $assign) {
				$data_assigns[] = [
					'structure' => [
						'name' => !empty($assign->structure) ? $assign->structure->nama_struktur : null,
					],
					'employee' => [
						'name' => !empty($assign->employee) ? $assign->employee->name : null,
					],
					'class_disposition' => [
						'name' => !empty($assign->class_disposition) ? $assign->class_disposition->name : null,
					]
				];
			}
		}
		
	   	return [
			'incoming_mail' => [
				'subject_letter' => !empty($data->incoming) ? $data->incoming->subject_letter : null,
				'number_letter' => !empty($data->incoming) ? $data->incoming->number_letter : null,
			],
			'number_disposition' => !empty($data->number_disposition) ? $data->number_disposition : null,
			'subject_disposition' => !empty($data->subject_disposition) ? $data->subject_disposition : null,
			'disposition_date' => !empty($data->disposition_date) ? $data->disposition_date : null,
			'employee' => [
				'name' => !empty($data->employee) ? $data->employee->name : null,
			],
		   	'assigns' => !empty($data_assigns) ? $data_assigns : null
	   	];
	}
}