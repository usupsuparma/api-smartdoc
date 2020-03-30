<?php namespace App\Library\Managers\Smartdoc\Facade;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Support\Facades\Facade;

class Smartdoc extends Facade
{
	protected static function getFacadeAccessor() 
	{
		return 'smartdoc'; 
	}
}