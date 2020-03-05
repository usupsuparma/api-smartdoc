<?php namespace App\Modules\Test\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class TestRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Test\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/test';
	}

	public function bind(Application $app)
	{
		$app->router->group([
			'prefix' => $this->route_prefix,
			'namespace' => $this->controller_ns
		], function () use ($app) {
			$app->router->get('/', [
				'as' => $this->route_prefix . '.data',
				'uses' => 'TestController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.data',
				'uses' => 'TestController@show'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'TestController@create'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'TestController@update'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'TestController@delete'
			]);
			
			$app->router->get('/generate/pdf', [
				'as' => $this->route_prefix . '.generate',
				'uses' => 'TestController@generate'
			]);
	
		});
	}
}
