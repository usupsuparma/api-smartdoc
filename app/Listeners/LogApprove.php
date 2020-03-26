<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\LogWasApprove;
use App\Modules\Log\Models\LogModel;
use Auth;

class LogApprove
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
     * @param  LogWasApprove  $event
     * @return void
     */
    public function handle(LogWasApprove $event)
    { 
        $name = class_basename($event->actionLog);
        $model = str_replace('Model', '', $name);

        LogModel::create([
            'user_id' => Auth::user()->id,
            'model' => $model,
            'type' => 'created',
            'reference_id' => $event->actionLog->id,
            'activity' => "Melakukan persetujuan pada data {$model} ",
            'visitor' => app('request')->ip()
        ]);
    }
}
