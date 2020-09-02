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
			
			$app->router->get('/select/disposition', [
				'as' => $this->route_prefix . '.option_disposition',
				'uses' => 'OrganizationController@option_disposition'
			]);
			
			$app->router->get('/', [
				'as' => $this->route_prefix . '.data',
				'uses' => 'OrganizationController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.show',
				'uses' => 'OrganizationController@show'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'OrganizationController@create'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'OrganizationController@update'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'OrganizationController@delete'
			]);
			
			$app->router->post('/ordering', [
				'as' => $this->route_prefix . '.ordering',
				'uses' => 'OrganizationController@ordering'
			]);
	
		});
	}
}
