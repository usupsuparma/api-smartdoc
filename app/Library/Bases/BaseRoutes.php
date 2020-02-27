<?php namespace App\Library\Bases;

use Laravel\Lumen\Application;

abstract class BaseRoutes 
{
	protected $controller_ns;
	protected $route_prefix;
	
	const GLOBAL_PREFIX = 'api/v1';

	abstract public function bind(Application $app);
}