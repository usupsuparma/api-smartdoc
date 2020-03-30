<?php namespace App\Library\Managers\Smartdoc\Providers;
/**
 *  @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Support\ServiceProvider;
use App\Library\Managers\Smartdoc\Smartdoc;

class SmartdocServiceProvider extends ServiceProvider
{
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('smartdoc', function ($app) {
			return new Smartdoc();
		});
	}
}