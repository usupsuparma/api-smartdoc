<?php namespace App\Modules\Master\TypeNote\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class TypeNoteRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Master\TypeNote\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/type-notes';
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
				'uses' => 'TypeNoteController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.data',
				'uses' => 'TypeNoteController@show'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'TypeNoteController@create'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'TypeNoteController@update'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'TypeNoteController@delete'
			]);
	
		});
	}
}
