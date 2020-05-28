<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\NotificationMobile;
use OneSignal;

class NotifMobile
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
     * @param  NotificationMobile  $event
     * @return void
     */
    public function handle(NotificationMobile $event)
    {
		OneSignal::sendNotificationCustom([
			'api_id' => env('ONESIGNAL_APP_ID'),
			'api_key' => env('ONESIGNAL_API_KEY'),
			'include_player_ids' => [$event->notifData['device_id']],
			'data' => $event->notifData['data'],
			'headings' => ['en' => $event->notifData['heading']],
			'contents' => ['en' => $event->notifData['content']]
		]);
    }
}
