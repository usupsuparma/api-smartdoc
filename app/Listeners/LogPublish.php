<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\LogWasPublish;
use App\Modules\Log\Models\LogModel;
use Auth;

class LogPublish
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
     * @param  LogWasPublish  $event
     * @return void
     */
    public function handle(LogWasPublish $event)
    {
        $name = class_basename($event->actionLog);
        $model = str_replace('Model', '', $name);

        LogModel::create([
            'user_id' => Auth::user()->id,
            'model' => $model,
            'type' => 'created',
            'reference_id' => $event->actionLog->id,
            'activity' => "Melakukan publish pada data {$model} ",
            'visitor' => app('request')->ip()
        ]);
    }
}
