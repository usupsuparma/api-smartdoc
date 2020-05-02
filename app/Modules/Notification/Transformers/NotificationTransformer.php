<?php namespace App\Modules\Notification\Transformers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
	/** 
	 * Type Transformer
	 * @return array
	 */
	
	 public function transform($data) 
	 {
		return [
			'id' => (int) $data->id,
			'heading' => (string) $data->heading,
			'title' => (string) $data->title,
			'content' => $data->content,
			'data' => unserialize($data->data),
			'redirect_web' => $data->redirect_web,
			'redirect_mobile' => $data->redirect_mobile,
			'sender' => [
				'name' => $data->sender->name,
				'structure_name' => $data->sender->user->structure->nama_struktur,
				'position_name' => $data->sender->user->position->nama_jabatan,
			],
			'receiver' => [
				'name' => $data->receiver->name,
				'structure_name' => $data->receiver->user->structure->nama_struktur,
				'position_name' => $data->receiver->user->position->nama_jabatan,
			],
			'is_read' => (bool) $data->is_read,
			'created_at' => $data->created_at->format('d-m-Y'),
			'updated_at' => $data->updated_at->format('d-m-Y')
		];
	 }
}