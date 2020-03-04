<?php namespace App\Modules\Menu\Route;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class MenuRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Menu\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/menus';
	}

	public function bind(Application $app)
	{
		$app->router->group([
			'prefix' => $this->route_prefix,
			'namespace' => $this->controller_ns,
			'middleware' => ['auth', 'cors']
		], function () use ($app) {
			$app->router->get('/', [
				'as' => $this->route_prefix . '.data',
				'uses' => 'MenuController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.show',
				'uses' => 'MenuController@show'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'MenuController@create'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'MenuController@update'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'MenuController@delete'
			]);
	
		});
	}
}
