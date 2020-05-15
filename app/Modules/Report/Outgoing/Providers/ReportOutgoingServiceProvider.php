<?php namespace App\Modules\Report\Outgoing\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Report\Outgoing\Route\ReportOutgoingRoutes;

use Illuminate\Support\ServiceProvider;

class ReportOutgoingServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(ReportOutgoingRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
