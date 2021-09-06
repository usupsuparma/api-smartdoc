<?php namespace App\Modules\MappingStructure\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\MappingStructure\Route\MappingStructureRoutes;

use Illuminate\Support\ServiceProvider;

class MappingStructureServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(MappingStructureRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
