<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\LogWasCreate;
use Auth;

class LogCreate
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
     * @param  LogWasCreate  $event
     * @return void
     */
    public function handle(LogWasCreate $event)
    {    
        
    }
}
