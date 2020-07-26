<?php namespace App\Modules\Archive\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Archive\Route\ArchiveIncomingRoutes;

use Illuminate\Support\ServiceProvider;

class ArchiveIncomingServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(ArchiveIncomingRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
