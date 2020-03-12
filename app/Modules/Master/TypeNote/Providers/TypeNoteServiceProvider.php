<?php namespace App\Modules\Master\TypeNote\Providers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Master\TypeNote\Route\TypeNoteRoutes;

use Illuminate\Support\ServiceProvider;

class TypeNoteServiceProvider extends ServiceProvider
{
	public function register()
	{
		$registry = $this->app->make(TypeNoteRoutes::class);
		
		if (!is_object($registry)) {
			Log::info('Not adding any service routes - route file is missing');
			return;
		}

		$registry->bind(app());
	}
}
