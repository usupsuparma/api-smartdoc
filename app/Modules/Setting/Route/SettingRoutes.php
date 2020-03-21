<?php namespace App\Modules\Setting\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class SettingRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Setting\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/settings';
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
				'uses' => 'SettingController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.data',
				'uses' => 'SettingController@show'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'SettingController@create'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'SettingController@update'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'SettingController@delete'
			]);
	
		});
	}
}
