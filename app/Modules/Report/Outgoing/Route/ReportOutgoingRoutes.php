<?php namespace App\Modules\Report\Outgoing\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class ReportOutgoingRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Report\Outgoing\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/reports/outgoing';
	}

	public function bind(Application $app)
	{
		$app->router->group([
			'prefix' => $this->route_prefix,
			'namespace' => $this->controller_ns,
		], function () use ($app) {
			$app->router->get('/', [
				'middleware' => 'auth',
				'as' => $this->route_prefix . '.data',
				'uses' => 'ReportOutgoingController@data'
			]);
			
			$app->router->get('/export', [
				'as' => $this->route_prefix . '.export_data',
				'uses' => 'ReportOutgoingController@export_data'
			]);
	
		});
	}
}
