<?php namespace App\Modules\OutgoingMail\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class OutgoingMailTransformer extends TransformerAbstract
{
	/** 
	 * OutgoingMail Transformer
	 * @return array
	 */
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'number_letter' => !empty($data->number_letter) ? $data->number_letter : null,
			'subject_letter' => !empty($data->subject_letter) ? $data->subject_letter : null,
			'letter_date' => $data->letter_date,
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
			'from_employee' => [
				'id' => !empty($data->from_employee) ? $data->from_employee->id_employee : null,
				'name' => !empty($data->from_employee) ? $data->from_employee->name : null,
			],
			'created_by' => [
				'id' => !empty($data->created_by) ? $data->created_by->id_employee : null,
				'name' => !empty($data->created_by) ? $data->created_by->name : null,
				'structure_name' => !empty($data->created_by->user->structure) ? $data->created_by->user->structure->nama_struktur : null,
			],
			'status' => [
				'action' => config('constans.status-action.'. $data->status),
				'employee_name' => !empty($data->current_approval_employee) ? $data->current_approval_employee->name : '',
			],
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	 }
	 
	 /** 
	 * OutgoingMail Transformer Custom
	 * @return array
	 */
	public static function customTransform($data) 
	{
	   	$data_attachments = [];
	   	$data_forwards = [];
	   	$history_approvals = [];
	   
	   	if (!empty($data->attachments)) {
			foreach ($data->attachments as $attach) {
				$data_attachments[] = [
					'id_attachment' => $attach['id'],
					'attachment_name' => $attach['attachment_name'],
				];
			}
		}
		   
		if (!empty($data->forwards)) {
			foreach ($data->forwards as $forward) {
				$data_forwards[] = [
					'id_forward' => $forward['id'],
					'employee_id' => $forward['employee_id'],
					'employee_name' => $forward->employee->name
				];
			}
		}
		
		if (!empty($data->history_approvals)) {
			foreach ($data->history_approvals as $history) {
				$history_approvals[] = [
					'employee' => [
						'nik' => !empty($history->employee) ? $history->employee->nik : '',
						'name' => !empty($history->employee) ? $history->employee->name : '',
					],
					'structure_name' => !empty($history->structure) ? $history->structure->nama_struktur : '',
					'notes' => $history->description,
					'status' => [
						'status_code' => (int) $history->status_approval,
						'status_name' => config('constans.status-approval.'. $history->status_approval),
					],
					'create_at' => $data->updated_at->format('d M Y H:i:s'),
				];
			}
		}
		
	   	return [
			'id' => (int) $data->id,
			'number_letter' => !empty($data->number_letter) ? $data->number_letter : null,
			'subject_letter' => !empty($data->subject_letter) ? $data->subject_letter : null,
			'letter_date' => $data->letter_date,
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
			'from_employee' => [
				'id' => !empty($data->from_employee) ? $data->from_employee->id_employee : null,
				'name' => !empty($data->from_employee) ? $data->from_employee->name : null,
			],
			'history_approvals' => !empty($history_approvals) ? $history_approvals : null,
			'body' => $data->body,
			'forwards' => $data_forwards,
		   	'attachments' => $data_attachments,
	   	];
	}
}