<?php namespace App\Modules\Dashboard\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class DashboardRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Dashboard\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/dashboard';
	}

	public function bind(Application $app)
	{
		$app->router->group([
			'prefix' => $this->route_prefix,
			'namespace' => $this->controller_ns,
			'middleware' => 'auth'
		], function () use ($app) {
			$app->router->get('/count-mail', [
				'as' => $this->route_prefix . '.get_count_all_mail',
				'uses' => 'DashboardController@get_count_all_mail'
			]);
		});
	}
}
