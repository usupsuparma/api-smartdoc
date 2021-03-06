<?php namespace App\Modules\OutgoingMail\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class SignedOutgoingMailRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\OutgoingMail\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/outgoing-mails-signed';
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
				'uses' => 'SignedOutgoingMailController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.show',
				'uses' => 'SignedOutgoingMailController@show'
			]);
			
			$app->router->put('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'SignedOutgoingMailController@update'
			]);
	
		});
	}
}
