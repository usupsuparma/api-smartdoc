<?php namespace App\Modules\MappingFollowOutgoing\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class MappingFollowOutgoingRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\MappingFollowOutgoing\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/mapping-follow-outgoing';
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
				'uses' => 'MappingFollowOutgoingController@data'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'MappingFollowOutgoingController@create'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'MappingFollowOutgoingController@delete'
			]);
		});
	}
}
