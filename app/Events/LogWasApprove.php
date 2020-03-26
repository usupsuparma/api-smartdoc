<?php namespace App\Events;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Queue\SerializesModels;

class LogWasApprove extends Event
{
	use SerializesModels;
	
    public $actionLog;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($actionLog = [])
    {
        $this->actionLog = $actionLog;
    }
}
