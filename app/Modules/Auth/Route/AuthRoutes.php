<?php namespace App\Modules\Auth\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class AuthRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Auth\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/auth';
	}

	public function bind(Application $app)
	{
		$app->router->group(['prefix' => $this->route_prefix, 'namespace' => $this->controller_ns], function () use ($app) {
			$app->router->post('login', [
				'as' => $this->route_prefix . '.login',
				'uses' => 'AuthController@login'
			]);
			
			$app->router->get('logout', [
				'as' => $this->route_prefix . '.logout',
				'uses' => 'AuthController@logout'
			]);
		});
	}
}
