<?php namespace App\Modules\IncomingMail\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\IncomingMail\Route\IncomingMailRoutes;

use Illuminate\Support\ServiceProvider;

class IncomingMailServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(IncomingMailRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
