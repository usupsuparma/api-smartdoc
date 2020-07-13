<?php namespace App\Modules\External\Users\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class UsersRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\External\Users\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/integrate-users';
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
	}
}
