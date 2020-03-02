<?php namespace App\Modules\Role\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class RoleRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Role\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/Roles';
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
				'uses' => 'RoleController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.show',
				'uses' => 'RoleController@show'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'RoleController@create'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'RoleController@update'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'RoleController@delete'
			]);
	
		});
	}
}
