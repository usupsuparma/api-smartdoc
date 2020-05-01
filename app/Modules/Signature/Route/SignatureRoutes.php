<?php namespace App\Modules\Signature\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class SignatureRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Signature\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/digital-signatures';
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
				'uses' => 'SignatureController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.data',
				'uses' => 'SignatureController@show'
			]);
			
			$app->router->post('/', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'SignatureController@create'
			]);
			
			$app->router->post('/update/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'SignatureController@update'
			]);
			
			$app->router->delete('/{id}', [
				'as' => $this->route_prefix . '.delete',
				'uses' => 'SignatureController@delete'
			]);
			
			$app->router->get('/download/{id}', [
				'as' => $this->route_prefix . '.download',
				'uses' => 'SignatureController@download'
			]);
			
			$app->router->post('/generate/{employee_id}', [
				'as' => $this->route_prefix . '.generate',
				'uses' => 'SignatureController@generate'
			]);
			
			$app->router->get('/check/available-signature', [
				'as' => $this->route_prefix . '.check',
				'uses' => 'SignatureController@check'
			]);
		});
	}
}
