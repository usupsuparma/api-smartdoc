<?php namespace App\Modules\Report\Outgoing\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;
use App\Modules\OutgoingMail\Constans\OutgoingMailStatusConstants;
use Carbon\Carbon;
class ReportOutgoingTransformer extends TransformerAbstract
{
	/** 
	 * OutgoingMail Transformer
	 * @return array
	 */
	 public function transform($data) 
	 {
		$file = false;
		
		if ($data->status == (OutgoingMailStatusConstants::PUBLISH || OutgoingMailStatusConstants::SIGNED)) {
			$file = true;
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
			'created_by' => [
				'id' => !empty($data->created_by) ? $data->created_by->id_employee : null,
				'name' => !empty($data->created_by) ? $data->created_by->name : null,
				'structure_name' => !empty($data->created_by->user->structure) ? $data->created_by->user->structure->nama_struktur : null,
			],
			'status' => [
				'action' => config('constans.status-action.'. $data->status),
				'employee_name' => !empty($data->current_approval_employee) ? $data->current_approval_employee->name : '',
				'status_code' => (int) $data->status
			],
			'file' => $file,
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
		
		Carbon::setLocale('id');
		
		if (!empty($data->history_approvals)) {
			foreach ($data->history_approvals as $history) {
				$history_approvals[] = [
					'id' => $history->id,
					'employee' => [
						'nik' => !empty($history->employee) ? $history->employee->nik : '',
						'name' => !empty($history->employee) ? $history->employee->name : '',
					],
					'structure_name' => !empty($history->structure) ? $history->structure->nama_struktur : '',
					'notes' => $history->description,
					'attachment' => !empty($history->path_to_file) ? true : false,
					'status' => [
						'status_code' => (int) $history->status_approval,
						'status_name' => config('constans.status-approval.'. $history->status_approval),
					],
					'create_at' => Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->format('d M Y H:i:s'),
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
			'structure_name' => !empty($data->structure_by) ? $data->structure_by->nama_struktur : null,
			'body' => $data->body,
			'forwards' => !empty($data_forwards) ? $data_forwards : null,
		   	'attachments' => !empty($data_attachments) ? $data_attachments : null,
			'status' => $data->status,
			'history_approvals' => !empty($history_approvals) ? $history_approvals : null,
			'signature_available' => !empty($data->signature) ? true : false,
	   	];
	}
}