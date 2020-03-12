<?php namespace App\Modules\Master\ClassDisposition\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class ClassDispositionRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Master\ClassDisposition\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/class-dispositions';
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
				'uses' => 'ClassDispositionController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.data',
				'uses' => 'ClassDispositionController@show'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'ClassDispositionController@create'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'ClassDispositionController@update'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'ClassDispositionController@delete'
			]);
	
		});
	}
}
