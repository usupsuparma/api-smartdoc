<?php namespace App\Modules\Master\ClassDisposition\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Master\ClassDisposition\Route\ClassDispositionRoutes;

use Illuminate\Support\ServiceProvider;

class ClassDispositionServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(ClassDispositionRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
