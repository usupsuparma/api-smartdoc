<?php namespace App\Modules\Auth\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Auth\Route\AuthRoutes;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(AuthRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
