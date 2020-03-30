<?php namespace App\Modules\Review\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Review\Route\ReviewRoutes;

use Illuminate\Support\ServiceProvider;

class ReviewServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(ReviewRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
