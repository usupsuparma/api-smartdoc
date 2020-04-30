<?php namespace App\Modules\Disposition\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Disposition\Route\DispositionFollowRoutes;

use Illuminate\Support\ServiceProvider;

class DispositionFollowServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(DispositionFollowRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
