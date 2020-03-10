<?php namespace App\Library\Managers\Navigation\Facade;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Support\Facades\Facade;

class Navigation extends Facade
{
	protected static function getFacadeAccessor() 
	{
		return 'navigation'; 
	}
}