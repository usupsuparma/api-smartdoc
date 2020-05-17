<?php namespace App\Modules\Report\Disposition\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Report\Disposition\Route\ReportDispositionRoutes;

use Illuminate\Support\ServiceProvider;

class ReportDispositionServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(ReportDispositionRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
