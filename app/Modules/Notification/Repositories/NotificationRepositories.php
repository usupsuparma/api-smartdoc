<?php namespace App\Modules\Notification\Repositories;
/**
 * Class NotificationRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Notification\Interfaces\NotificationInterface;
use App\Modules\Notification\Models\NotificationModel;

class NotificationRepositories extends BaseRepository implements NotificationInterface
{	
	public function model()
	{
		return NotificationModel::class;
	}
	
    public function notification_user()
    {
		$query = $this->model->byUser();

		return $query->get(); 
	}
	
	public function read_notification($id)
    {
		$model = $this->model->readNotif($id)->firstOrFail();
		
		return $model->update(['is_read' => true]); 
	}
}
