<?php namespace App\Events;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Queue\SerializesModels;

class Notification extends Event
{
	use SerializesModels;
	
    public $notif;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notif = [])
    {
        $this->notif = $notif;
    }
}
