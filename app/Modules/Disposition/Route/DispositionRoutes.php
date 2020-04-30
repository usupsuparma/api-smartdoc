<?php namespace App\Modules\Disposition\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class DispositionRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Disposition\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/dispositions';
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
				'uses' => 'DispositionController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.show',
				'uses' => 'DispositionController@show'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'DispositionController@create'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'DispositionController@update'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'DispositionController@delete'
			]);
			
			$app->router->post('/update/follow-up/{id}', [
				'as' => $this->route_prefix . '.follow_up',
				'uses' => 'DispositionController@follow_up'
			]);
			
			$app->router->get('/download/attachment-main/{id}', [
				'as' => $this->route_prefix . '.download_attachment_main',
				'uses' => 'DispositionController@download_attachment_main'
			]);
			
			$app->router->get('/download/attachment/{attachment_id}', [
				'as' => $this->route_prefix . '.download_attachment',
				'uses' => 'DispositionController@download_attachment'
			]);
	
		});
	}
}
