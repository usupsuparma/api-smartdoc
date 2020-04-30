<?php namespace App\Modules\Disposition\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;
use Auth;

class DispositionTransformer extends TransformerAbstract
{
	/** 
	 * Disposition Transformer
	 * @return array
	 */
	 public function transform($data) 
	 {
		$follow_up = false;
		
		// if ($data->follow_ups->isEmpty() && $data->status == IncomingMailStatusConstans::SEND) {
		// 	if ($data->to_employee_id == Auth::user()->user_core->id_employee) {
		// 		$follow_up = true;
		// 	}
		// }
		
		return [
			'id' => (int) $data->id,
			'incoming_mail' => [
				'id' => !empty($data->incoming) ? $data->incoming->id : null,
				'subject_letter' => !empty($data->incoming) ? $data->incoming->subject_letter : null,
				'number_letter' => !empty($data->incoming) ? $data->incoming->number_letter : null,
			],
			'number_disposition' => !empty($data->number_disposition) ? $data->number_disposition : null,
			'subject_disposition' => !empty($data->subject_disposition) ? $data->subject_disposition : null,
			'disposition_date' => !empty($data->disposition_date) ? $data->disposition_date : null,
			'from_employee' => [
				'id' => !empty($data->employee) ? $data->employee->id_employee : null,
				'name' => !empty($data->employee) ? $data->employee->name : null,
			],
			'status' => [
				'action' => config('constans.status-action-in.'. $data->status),
				'status_code' => (int) $data->status
			],
			// 'follow_up' =>$follow_up,
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	}
	 
	/** 
	 * Disposition Transformer Custom
	 * @return array
	 */
	public static function customTransform($data) 
	{
	   	$data_assigns = [];
	   	$progress = $data->assign->count();
	   
	   	if (!empty($data->assign)) {
			foreach ($data->assign as $assign) {
				$data_assigns[] = [
					'id' => $assign['id'],
					'structure' => [
						'id' => !empty($assign->structure) ? $assign->structure->id : null,
						'name' => !empty($assign->structure) ? $assign->structure->nama_struktur : null,
					],
					'employee' => [
						'id' => !empty($assign->employee) ? $assign->employee->id_employee : null,
						'name' => !empty($assign->employee) ? $assign->employee->name : null,
					],
					'class_disposition' => [
						'id' => !empty($assign->class_disposition) ? $assign->class_disposition->id : null,
						'name' => !empty($assign->class_disposition) ? $assign->class_disposition->name : null,
					],
				];
			}
		}
		
	   	return [
			'id' => (int) $data->id,
			'incoming_mail' => [
				'id' => !empty($data->incoming) ? $data->incoming->id : null,
				'subject_letter' => !empty($data->incoming) ? $data->incoming->subject_letter : null,
				'number_letter' => !empty($data->incoming) ? $data->incoming->number_letter : null,
			],
			'number_disposition' => !empty($data->number_disposition) ? $data->number_disposition : null,
			'subject_disposition' => !empty($data->subject_disposition) ? $data->subject_disposition : null,
			'disposition_date' => !empty($data->disposition_date) ? $data->disposition_date : null,
			'description' => !empty($data->description) ? $data->description : null,
			'employee' => [
				'id' => !empty($data->employee) ? $data->employee->id_employee : null,
				'name' => !empty($data->employee) ? $data->employee->name : null,
			],
		   	'assigns' => !empty($data_assigns) ? $data_assigns : null,
		   	'progress' => $progress,
		   	'signature_available' => !empty($data->signature) ? true : false,
			'status' => $data->status,
	   	];
	}
}