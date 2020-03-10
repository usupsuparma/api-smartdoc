<?php namespace App\Library\Managers\Navigation\Providers;
/**
 *  @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Support\ServiceProvider;
use App\Library\Managers\Navigation\Navigation;

class NavigationServiceProvider extends ServiceProvider
{
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('navigation', function ($app) {
			return new Navigation();
		});
	}
}