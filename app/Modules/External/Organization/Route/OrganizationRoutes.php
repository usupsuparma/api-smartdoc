<?php namespace App\Modules\External\Organization\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class OrganizationRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\External\Organization\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/organizations';
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
				'uses' => 'OrganizationController@options'
			]);
	
		});
	}
}
