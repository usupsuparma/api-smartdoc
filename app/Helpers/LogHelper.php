<?php

use App\Events\LogWasCreate;
use App\Events\LogWasUpdate;
use App\Events\LogWasDelete;
use App\Events\LogWasDisposition;

if (!function_exists('created_log')) {
	
    function created_log($actionLog = [])
    {
        event(new LogWasCreate($actionLog));
    }
}

if (!function_exists('updated_log')) {
	
    function updated_log($actionLog = [])
    {
        event(new LogWasUpdate($actionLog));
    }
}

if (!function_exists('deleted_log')) {
	
    function deleted_log($actionLog = [])
    {
        event(new LogWasDelete($actionLog));
    }
}