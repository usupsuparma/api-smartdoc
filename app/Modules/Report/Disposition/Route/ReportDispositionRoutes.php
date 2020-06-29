<?php namespace App\Modules\Report\Disposition\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class ReportDispositionRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Report\Disposition\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/reports/disposition';
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
				'uses' => 'ReportDispositionController@data'
			]);
			
			$app->router->get('/export', [
				'middleware' => 'checkToken',
				'as' => $this->route_prefix . '.export_data',
				'uses' => 'ReportDispositionController@export_data'
			]);
		});
	}
}
