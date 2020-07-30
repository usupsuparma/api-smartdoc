<?php namespace App\Modules\SpecialDivisionOutgoing\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class SpecialDivisionOutgoingRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\SpecialDivisionOutgoing\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/special-division-outgoing';
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
				'uses' => 'SpecialDivisionOutgoingController@data'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'SpecialDivisionOutgoingController@create'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'SpecialDivisionOutgoingController@delete'
			]);
		});
	}
}
