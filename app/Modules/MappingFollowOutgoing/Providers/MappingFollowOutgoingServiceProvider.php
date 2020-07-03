<?php namespace App\Modules\MappingFollowOutgoing\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\MappingFollowOutgoing\Route\MappingFollowOutgoingRoutes;

use Illuminate\Support\ServiceProvider;

class MappingFollowOutgoingServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(MappingFollowOutgoingRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
