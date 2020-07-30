<?php namespace App\Modules\IncomingMail\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use App\Helpers\SmartdocHelper;
use Auth;

class IncomingMailTransformer extends TransformerAbstract
{
	/** 
	 * IncomingMail Transformer
	 * @return array
	 */
	 public function transform($data) 
	 {
		$follow_up = false;
		$disposition = false;
		$status = false;
		$bod_level = false;
		
		if ($data->status != IncomingMailStatusConstans::DRAFT || $data->status != IncomingMailStatusConstans::SEND) {
			$status = true;
		}
		
		if ($data->follow_ups->isEmpty() && $data->status == IncomingMailStatusConstans::SEND) {
			if ($data->to_employee_id == Auth::user()->user_core->id_employee) {
				$follow_up = true;
			}
		}

		if ($data->to_employee_id == Auth::user()->user_core->id_employee && empty($data->disposition)) {
			$disposition = true;
		}
		
		/* Open Disposition IF BOD LEVEL not complete Follow Up */
		if (SmartdocHelper::bod_level()) {
			$bod_level = true;
		}
		
		return [
			'id' => (int) $data->id,
			'number_letter' => !empty($data->number_letter) ? $data->number_letter : null,
			'subject_letter' => !empty($data->subject_letter) ? $data->subject_letter : null,
			'sender_name' => !empty($data->sender_name) ? $data->sender_name : null,
			'receiver_name' => !empty($data->receiver_name) ? $data->receiver_name : null,
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
			'status' => [
				'action' => config('constans.status-action-in.'. $data->status),
				'employee_name' => ($status ? (!empty($data->to_employee) ? $data->to_employee->name : '') : null),
				'status_code' => (int) $data->status
			],
			'follow_up' => $follow_up,
			'is_read' => $data->is_read,
			'disposition' => $disposition,
			'bod_level' => $bod_level,
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	 }
	 
	/** 
	 * IncomingMail Transformer Custom
	 * @return array
	 */
	public static function customTransform($data) 
	{
	   	$data_attachments = [];
	   	$data_follow_ups = [];
	   
	   	if (!empty($data->attachments)) {
			foreach ($data->attachments as $attach) {
				$data_attachments[] = [
					'id_attachment' => $attach['id'],
					'attachment_name' => $attach['attachment_name'],
				];
			}
		}

		if (!empty($data->follow_ups)) {
			foreach ($data->follow_ups as $fu) {
				$data_follow_ups[] = [
					'id_follow_up' => $fu['id'],
					'employee' => [
						'employee_id' => $fu['employee_id'],
						'employee_name' => $fu->employee->name
					],
					'description' => $fu['description']
				];
			}
		}
		
	   	return [
			'id' => (int) $data->id,
			'number_letter' => !empty($data->number_letter) ? $data->number_letter : null,
			'subject_letter' => !empty($data->subject_letter) ? $data->subject_letter : null,
			'sender_name' => !empty($data->sender_name) ? $data->sender_name : null,
			'receiver_name' => !empty($data->receiver_name) ? $data->receiver_name : null,
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
			'follows' => !empty($data_follow_ups) ? $data_follow_ups : null,
			'attachments' => !empty($data_attachments) ? $data_attachments : null,
			'is_read' => $data->is_read,
			'status' => $data->status
		];
	}
}