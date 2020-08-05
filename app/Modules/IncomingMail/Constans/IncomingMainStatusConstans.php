<?php namespace App\Modules\IncomingMail\Constans;
/**
 * @author Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

class IncomingMailStatusConstans
{
	const DRAFT = 0 ;
	const SEND = 1 ;
	const DISPOSITION = 2;
	const FOLLOW_UP = 3;
	const DONE = 4;
	
	const IS_NOT_ARCHIVE = 0 ;
	const IS_ARCHIVE = 1 ;
	
	const INTERNAL = 1 ;
	const EXTERNAL = 2 ;
}