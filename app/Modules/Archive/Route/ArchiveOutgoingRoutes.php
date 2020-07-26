<?php namespace App\Modules\Archive\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class ArchiveOutgoingRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Archive\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/archive-outgoings';
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
				'uses' => 'ArchiveOutgoingController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.show',
				'uses' => 'ArchiveOutgoingController@show'
			]);
		});
	}
}
