<?php namespace App\Modules\SpecialDivisionOutgoing\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\SpecialDivisionOutgoing\Route\SpecialDivisionOutgoingRoutes;

use Illuminate\Support\ServiceProvider;

class SpecialDivisionOutgoingServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(SpecialDivisionOutgoingRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
