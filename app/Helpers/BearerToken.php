<?php namespace App\Helpers;

use Illuminate\Support\Str;

class BearerToken
{
	public static function get_token($request)
	{
		$header = $request->header('Authorization', '');
		
		if (Str::startsWith($header, 'Bearer ')) {
			return Str::substr($header, 7);
		}
	}
}