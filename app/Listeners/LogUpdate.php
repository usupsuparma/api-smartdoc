<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\LogWasUpdate;
use App\Modules\Log\Models\LogModel;
use Auth;
class LogUpdate
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
     * @param  LogWasUpdate  $event
     * @return void
     */
    public function handle(LogWasUpdate $event)
    {
        $name = class_basename($event->actionLog);
        $model = str_replace('Model', '', $name);

        LogModel::create([
            'user_id' => Auth::check() ? Auth::user()->id : NULL,
            'model' => $model,
            'type' => 'updated',
            'reference_id' => $event->actionLog->id,
            'activity' => "Melakukan perubahan pada data {$model} ",
            'visitor' => app('request')->ip()
        ]);
    }
}
