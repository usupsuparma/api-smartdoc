<?php namespace App\Modules\Verification\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class OMTransformer extends TransformerAbstract
{
	/** 
	 * OutgoingMail Transformer
	 * @return array
	 */
	 public static function customTransform($data) 
	 {
		return [
			'number_letter' => !empty($data->number_letter) ? $data->number_letter : null,
			'subject_letter' => !empty($data->subject_letter) ? $data->subject_letter : null,
			'letter_date' => $data->letter_date,
			'retension_date' => $data->retension_date,
			'type' => [
				'name' => !empty($data->type) ? $data->type->name : null,
			],
			'classification' => [
				'name' => !empty($data->classification) ? $data->classification->name : null,
			],
			'to_employee' => [
				'name' => !empty($data->to_employee) ? $data->to_employee->name : null,
			],
			'from_employee' => [
				'name' => !empty($data->from_employee) ? $data->from_employee->name : null,
			],
			'created_by' => [
				'name' => !empty($data->created_by) ? $data->created_by->name : null,
				'structure_name' => !empty($data->created_by->user->structure) ? $data->created_by->user->structure->nama_struktur : null,
			]
		];
	 }
}