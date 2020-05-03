<?php namespace App\Modules\Notification\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class NotificationRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Notification\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/notifications';
	}

	public function bind(Application $app)
	{
		$app->router->group([
			'prefix' => $this->route_prefix,
			'namespace' => $this->controller_ns,
			'middleware' => 'auth'
		], function () use ($app) {
			$app->router->get('/', [
				'as' => $this->route_prefix . '.notification_user',
				'uses' => 'NotificationController@notification_user'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.read_notification',
				'uses' => 'NotificationController@read_notification'
			]);
			
		});
	}
}
