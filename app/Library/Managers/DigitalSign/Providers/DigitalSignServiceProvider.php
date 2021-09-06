<?php namespace App\Library\Managers\DigitalSign\Providers;
/**
 *  @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Support\ServiceProvider;
use App\Library\Managers\DigitalSign\DigitalSign;

class DigitalSignServiceProvider extends ServiceProvider
{
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('digitalsign', function ($app) {
			return new DigitalSign();
		});
	}
}