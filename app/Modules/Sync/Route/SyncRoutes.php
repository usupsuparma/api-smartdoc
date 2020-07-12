<?php namespace App\Modules\Sync\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class SyncRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Sync\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/syncs';
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
				'uses' => 'SyncController@data'
			]);
			
			$app->router->get('/generate-sync', [
				'as' => $this->route_prefix . '.create',
				'uses' => 'SyncController@create'
			]);
			
			$app->router->get('/generate-token-client', [
				'as' => $this->route_prefix . '.generate_token_client',
				'uses' => 'SyncController@generate_token_client'
			]);
		});
	}
}
