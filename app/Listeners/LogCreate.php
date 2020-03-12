<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\LogWasCreate;
use App\Modules\Log\Models\LogModel;
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
        $name = class_basename($event->actionLog);
        $model = str_replace('Model', '', $name);

        LogModel::create([
            'user_id' => Auth::user()->id,
            'model' => $model,
            'type' => 'created',
            'reference_id' => $event->actionLog->id,
            'activity' => "Melakukan penambahan pada data {$model} ",
            'visitor' => app('request')->ip()
        ]);
    }
}
