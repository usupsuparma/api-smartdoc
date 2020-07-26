<?php namespace App\Modules\Archive\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Archive\Route\ArchiveDispositionRoutes;

use Illuminate\Support\ServiceProvider;

class ArchiveDispositionServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(ArchiveDispositionRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
