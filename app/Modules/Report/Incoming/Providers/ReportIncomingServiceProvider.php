<?php namespace App\Modules\Report\Incoming\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Report\Incoming\Route\ReportIncomingRoutes;

use Illuminate\Support\ServiceProvider;

class ReportIncomingServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(ReportIncomingRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
