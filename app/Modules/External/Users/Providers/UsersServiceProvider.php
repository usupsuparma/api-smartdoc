<?php namespace App\Modules\External\Users\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\External\Users\Route\UsersRoutes;

use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(UsersRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
