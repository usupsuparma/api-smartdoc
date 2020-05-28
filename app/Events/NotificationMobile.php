<?php namespace App\Events;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Queue\SerializesModels;

class NotificationMobile extends Event
{
	use SerializesModels;
	
    public $notifData;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notifData = [])
    {
        $this->notifData = $notifData;
    }
}
