<?php namespace App\Modules\Account\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class AccountRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Account\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/accounts';
	}

	public function bind(Application $app)
	{
		$app->router->group([
			'prefix' => $this->route_prefix,
			'namespace' => $this->controller_ns,
			'middleware' => 'auth'
		], function () use ($app) {
			$app->router->get('/', [
				'as' => $this->route_prefix . '.show',
				'uses' => 'AccountController@show'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.change_password',
				'uses' => 'AccountController@change_password'
			]);
			
		});
	}
}
