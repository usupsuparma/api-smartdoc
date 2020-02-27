<?php namespace App\Modules\Test\Providers;

use App\Modules\Test\Route\TestRoutes;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(TestRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
