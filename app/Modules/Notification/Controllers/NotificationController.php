<?php namespace App\Modules\Notification\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Notification\Repositories\NotificationRepositories;

class NotificationController extends BaseController 
{
	private $notificationRepository;
	
	public function __construct(NotificationRepositories $notificationRepository) 
	{
		$this->notificationRepository = $notificationRepository;
	}
	
	public function notification_user()
	{
		return $this->showAll($this->notificationRepository->notification_user(),200);
	}
	
	public function read_notification($id)
	{
		return $this->successResponse([
			'status' => $this->notificationRepository->read_notification($id)
		],200);
	}
}