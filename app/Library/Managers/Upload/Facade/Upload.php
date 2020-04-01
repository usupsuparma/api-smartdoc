<?php namespace App\Library\Managers\Upload\Facade;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Support\Facades\Facade;

class Upload extends Facade
{
	protected static function getFacadeAccessor() 
	{
		return 'upload'; 
	}
}