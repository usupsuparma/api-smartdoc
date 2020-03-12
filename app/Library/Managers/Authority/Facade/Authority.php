<?php namespace App\Library\Managers\Authority\Facade;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Support\Facades\Facade;

class Authority extends Facade
{
	protected static function getFacadeAccessor() 
	{
		return 'authority'; 
	}
}