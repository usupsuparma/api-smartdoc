<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\LogWasDelete;
use Auth;

class LogDelete
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
     * @param  LogWasDelete  $event
     * @return void
     */
    public function handle(LogWasDelete $event)
    {    
        
    }
}
