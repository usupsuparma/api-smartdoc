<?php namespace App\Modules\Sync\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Sync\Route\SyncRoutes;

use Illuminate\Support\ServiceProvider;

class SyncServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(SyncRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
