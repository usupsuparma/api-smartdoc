<?php namespace App\Modules\External\Employee\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class EmployeeRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\External\Employee\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/employees';
	}

	public function bind(Application $app)
	{
		$app->router->group([
			'prefix' => $this->route_prefix,
			'namespace' => $this->controller_ns,
			'middleware' => 'auth'
		], function () use ($app) {
			
			$app->router->get('/select/data', [
				'as' => $this->route_prefix . '.options',
				'uses' => 'EmployeeController@options'
			]);
			
			$app->router->get('/select/hierarchy', [
				'as' => $this->route_prefix . '.option_hierarchy',
				'uses' => 'EmployeeController@option_hierarchy'
			]);
	
		});
	}
}
