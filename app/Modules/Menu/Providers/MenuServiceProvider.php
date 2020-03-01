<?php namespace App\Modules\Menu\Providers;

use App\Modules\Menu\Route\MenuRoutes;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(MenuRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
