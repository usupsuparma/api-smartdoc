<?php namespace App\Modules\OutgoingMail\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\OutgoingMail\Route\SignedOutgoingMailRoutes;

use Illuminate\Support\ServiceProvider;

class SignedOutgoingMailServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(SignedOutgoingMailRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
