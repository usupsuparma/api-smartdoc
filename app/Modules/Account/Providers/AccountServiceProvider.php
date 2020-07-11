<?php namespace App\Modules\Account\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Account\Route\AccountRoutes;

use Illuminate\Support\ServiceProvider;

class AccountServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(AccountRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
