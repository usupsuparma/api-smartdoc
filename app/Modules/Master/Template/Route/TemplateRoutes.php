<?php namespace App\Modules\Master\Template\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class TemplateRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Master\Template\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/templates';
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
				'uses' => 'TemplateController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.data',
				'uses' => 'TemplateController@show'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'TemplateController@create'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'TemplateController@update'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'TemplateController@delete'
			]);
			
			$app->router->get('/type/{type_id}', [
				'as' => $this->route_prefix . '.template_by_type',
				'uses' => 'TemplateController@template_by_type'
			]);
	
		});
	}
}
