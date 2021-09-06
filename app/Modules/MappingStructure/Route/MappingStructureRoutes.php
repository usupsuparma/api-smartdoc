<?php namespace App\Modules\MappingStructure\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class MappingStructureRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\MappingStructure\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/mapping-structure';
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
				'uses' => 'MappingStructureController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.show',
				'uses' => 'MappingStructureController@show'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'MappingStructureController@update'
			]);
	
		});
	}
}
