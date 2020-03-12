<?php namespace App\Library\Managers\Authority\Providers;
/**
 *  @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Support\ServiceProvider;
use App\Library\Managers\Authority\Authority;

class AuthorityServiceProvider extends ServiceProvider
{
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('authority', function ($app) {
			return new Authority();
		});
	}
}