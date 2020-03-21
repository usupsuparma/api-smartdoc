<?php namespace App\Modules\Master\Template\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Master\Template\Route\TemplateRoutes;

use Illuminate\Support\ServiceProvider;

class TemplateServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(TemplateRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
