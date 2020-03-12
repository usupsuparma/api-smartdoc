<?php namespace App\Modules\Master\Type\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Master\Type\Route\TypeRoutes;

use Illuminate\Support\ServiceProvider;

class TypeServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(TypeRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
