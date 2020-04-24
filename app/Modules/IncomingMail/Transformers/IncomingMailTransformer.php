<?php namespace App\Modules\IncomingMail\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class IncomingMailTransformer extends TransformerAbstract
{
	/** 
	 * IncomingMail Transformer
	 * @return array
	 */
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'number_letter' => !empty($data->number_letter) ? $data->number_letter : null,
			'subject_letter' => !empty($data->subject_letter) ? $data->subject_letter : null,
			'sender_name' => !empty($data->number_letter) ? $data->number_letter : null,
			'receiver_name' => !empty($data->subject_letter) ? $data->subject_letter : null,
			'letter_date' => $data->letter_date,
			'recieved_date' => $data->recieved_date,
			'retension_date' => $data->retension_date,
			'type' => [
				'id' => !empty($data->type) ? $data->type->id : null,
				'name' => !empty($data->type) ? $data->type->name : null,
			],
			'classification' => [
				'id' => !empty($data->classification) ? $data->classification->id : null,
				'name' => !empty($data->classification) ? $data->classification->name : null,
			],
			'to_employee' => [
				'id' => !empty($data->to_employee) ? $data->to_employee->id_employee : null,
				'name' => !empty($data->to_employee) ? $data->to_employee->name : null,
			],
			'structure' => [
				'id' => !empty($data->structure) ? $data->structure->id : null,
				'name' => !empty($data->structure) ? $data->structure->nama_struktur : null
			],
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	 }
	 
	 
}