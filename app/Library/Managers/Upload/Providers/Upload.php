<?php namespace App\Library\Managers\Upload\Providers;
/**
 *  @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Support\ServiceProvider;
use App\Library\Managers\Upload\Upload;

class UploadServiceProvider extends ServiceProvider
{
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('upload', function ($app) {
			return new Upload();
		});
	}
}