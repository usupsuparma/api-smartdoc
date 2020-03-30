<?php namespace App\Modules\Review\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class ReviewRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Review\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/reviews';
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
				'uses' => 'ReviewController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.data',
				'uses' => 'ReviewController@show'
			]);
			
			$app->router->get('/{review_id}/detail', [
				'as' => $this->route_prefix . '.data_detail',
				'uses' => 'ReviewController@data_detail'
			]);
			
			$app->router->get('/{review_id}/detail/{id}', [
				'as' => $this->route_prefix . '.data_detail',
				'uses' => 'ReviewController@show_detail'
			]);
			
			$app->router->post('/{review_id}/detail', [
				'as' => $this->route_prefix . '.create_detail',
				'uses' => 'ReviewController@create_detail'
			]);
			
			$app->router->put('/{review_id}/detail/{id}', [
				'as' => $this->route_prefix . '.update_detail',
				'uses' => 'ReviewController@update_detail'
			]);
			
			$app->router->delete('/{review_id}/detail/{id}', [
				'as' => $this->route_prefix . '.delete_detail',
				'uses' => 'ReviewController@delete_detail'
			]);
	
		});
	}
}
