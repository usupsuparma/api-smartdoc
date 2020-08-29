<?php namespace App\Modules\Disposition\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class DispositionFollowRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Disposition\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/dispositions-follow';
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
				'uses' => 'DispositionFollowController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.show',
				'uses' => 'DispositionFollowController@show'
			]);
			
			$app->router->get('detail/{id}', [
				'as' => $this->route_prefix . '.show_detail',
				'uses' => 'DispositionFollowController@show_follow'
			]);
			
			$app->router->post('/update/follow-up/{id}', [
				'as' => $this->route_prefix . '.follow_up',
				'uses' => 'DispositionFollowController@follow_up'
			]);
			
			$app->router->get('/download/{id}', [
				'as' => $this->route_prefix . '.download',
				'uses' => 'DispositionFollowController@download'
			]);
		});
	}
}
