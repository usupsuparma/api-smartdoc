<?php namespace App\Modules\External\Users\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class UsersRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\External\Users\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/integrate-users';
		$this->route_prefix_external = BaseRoutes::GLOBAL_PREFIX . '/external-users';
	}

	public function bind(Application $app)
	{
		$app->router->group([
			'prefix' => $this->route_prefix,
			'namespace' => $this->controller_ns,
			'middleware' => 'client_credentials'
		], function () use ($app) {
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'UsersController@create'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'UsersController@update'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'UsersController@delete'
			]);
		});
		
		$app->router->group([
			'prefix' => $this->route_prefix_external,
			'namespace' => $this->controller_ns,
			'middleware' => 'auth'
		], function () use ($app) {
			$app->router->get('/', [
				'as' => $this->route_prefix . '.data_ex',
				'uses' => 'UsersController@data_ex'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.show_ex',
				'uses' => 'UsersController@show_ex'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create_ex',
				'uses' => 'UsersController@create_ex'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update_ex',
				'uses' => 'UsersController@update_ex'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete_ex',
				'uses' => 'UsersController@delete_ex'
			]);
		});
	}
}
