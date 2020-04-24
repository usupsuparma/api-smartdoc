<?php namespace App\Modules\IncomingMail\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class IncomingMailRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\IncomingMail\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/incoming-mails';
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
				'uses' => 'IncomingMailController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.show',
				'uses' => 'IncomingMailController@show'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'IncomingMailController@create'
			]);
			
			$app->router->post('/update/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'IncomingMailController@update'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'IncomingMailController@delete'
			]);
			
			$app->router->post('/update/follow-up/{id}', [
				'as' => $this->route_prefix . '.follow_up',
				'uses' => 'IncomingMailController@follow_up'
			]);
			
			$app->router->get('/download/attachment-main/{id}', [
				'as' => $this->route_prefix . '.download_attachment_main',
				'uses' => 'IncomingMailController@download_attachment_main'
			]);
			
			$app->router->delete('/attachment/{attachment_id}', [
				'as' => $this->route_prefix . '.delete_attachment',
				'uses' => 'IncomingMailController@delete_attachment'
			]);
			
			$app->router->get('/download/attachment/{attachment_id}', [
				'as' => $this->route_prefix . '.download_attachment',
				'uses' => 'IncomingMailController@download_attachment'
			]);
	
		});
	}
}
