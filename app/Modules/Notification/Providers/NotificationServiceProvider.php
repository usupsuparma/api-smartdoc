<?php namespace App\Modules\Notification\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Notification\Route\NotificationRoutes;

use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(NotificationRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
