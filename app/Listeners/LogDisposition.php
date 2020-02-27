<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\LogWasDisposition;
use Auth;

class LogDisposition
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
     * @param  LogWasDisposition  $event
     * @return void
     */
    public function handle(LogWasDisposition $event)
    {    
        
    }
}
