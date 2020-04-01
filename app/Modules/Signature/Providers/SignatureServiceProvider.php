<?php namespace App\Modules\Signature\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Signature\Route\SignatureRoutes;

use Illuminate\Support\ServiceProvider;

class SignatureServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(SignatureRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
