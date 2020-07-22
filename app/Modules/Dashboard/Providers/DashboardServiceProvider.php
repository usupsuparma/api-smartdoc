<?php namespace App\Modules\Dashboard\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Dashboard\Route\DashboardRoutes;

use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(DashboardRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
