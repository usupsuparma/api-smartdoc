<?php namespace App\Modules\Verification\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class VerificationRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\Verification\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/verify';
	}

	public function bind(Application $app)
	{
		$app->router->group([
			'prefix' => $this->route_prefix,
			'namespace' => $this->controller_ns
		], function () use ($app) {
			$app->router->get('/', [
				'as' => $this->route_prefix . '.verify',
				'uses' => 'VerificationController@verify'
			]);
		});
	}
}
