<?php namespace App\Modules\Verification\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Verification\Route\VerificationRoutes;

use Illuminate\Support\ServiceProvider;

class VerificationServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(VerificationRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
