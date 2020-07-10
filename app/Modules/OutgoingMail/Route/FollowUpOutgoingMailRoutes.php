<?php namespace App\Modules\OutgoingMail\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class FollowUpOutgoingMailRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\OutgoingMail\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/outgoing-mails-follow';
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
				'uses' => 'FollowUpOutgoingMailController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.show',
				'uses' => 'FollowUpOutgoingMailController@show'
			]);
			
			$app->router->post('/{id}', [
				'as' => $this->route_prefix . '.follow_up',
				'uses' => 'FollowUpOutgoingMailController@follow_up'
			]);
			
			$app->router->get('/download/{id}', [
				'as' => $this->route_prefix . '.download',
				'uses' => 'FollowUpOutgoingMailController@download'
			]);
		});
	}
}
