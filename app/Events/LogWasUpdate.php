<?php namespace App\Events;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

class LogWasUpdate extends Event
{
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
