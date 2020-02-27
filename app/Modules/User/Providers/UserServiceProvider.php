<?php namespace App\Modules\User\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\User\Route\UserRoutes;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(UserRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
