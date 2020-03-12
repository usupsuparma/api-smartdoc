<?php namespace App\Modules\Master\Classification\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Master\Classification\Route\ClassificationRoutes;

use Illuminate\Support\ServiceProvider;

class ClassificationServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(ClassificationRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
