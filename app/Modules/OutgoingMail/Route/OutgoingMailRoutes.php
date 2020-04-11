<?php namespace App\Modules\OutgoingMail\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class OutgoingMailRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\OutgoingMail\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/outgoing-mails';
	}

	public function bind(Application $app)
	{
		$app->router->group([
			'prefix' => $this->route_prefix,
			'namespace' => $this->controller_ns,
			'middleware' => 'auth'
		], function () use ($app) {
			$app->router->get('/', [
				'as' => $this->route_prefix . '.data',
				'uses' => 'OutgoingMailController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.show',
				'uses' => 'OutgoingMailController@show'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'OutgoingMailController@create'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'OutgoingMailController@update'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'OutgoingMailController@delete'
			]);
			
			$app->router->post('/approval', [
				'as' => $this->route_prefix . '.approval',
				'uses' => 'OutgoingMailController@approval'
			]);
			
			$app->router->post('/publish', [
				'as' => $this->route_prefix . '.publish',
				'uses' => 'OutgoingMailController@publish'
			]);
			
			$app->router->delete('/attachment/{id}', [
				'as' => $this->route_prefix . '.delete_attachment',
				'uses' => 'OutgoingMailController@delete_attachment'
			]);
	
		});
	}
}
