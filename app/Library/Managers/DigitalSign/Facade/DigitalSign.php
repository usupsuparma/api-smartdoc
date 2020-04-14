<?php namespace App\Library\Managers\DigitalSign\Facade;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Support\Facades\Facade;

class DigitalSign extends Facade
{
	protected static function getFacadeAccessor() 
	{
		return 'digitalsign'; 
	}
}