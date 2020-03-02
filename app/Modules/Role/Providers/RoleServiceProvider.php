<?php namespace App\Modules\Role\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Role\Route\RoleRoutes;

use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(RoleRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
