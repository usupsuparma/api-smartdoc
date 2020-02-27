<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\LogWasUpdate;
use Auth;

class LogUpdate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * Handle the event.
     *
     * @param  LogWasUpdate  $event
     * @return void
     */
    public function handle(LogWasUpdate $event)
    {    
        
    }
}
