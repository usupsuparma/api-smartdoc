<?php namespace App\Modules\Setting\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Setting\Route\SettingRoutes;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(SettingRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
