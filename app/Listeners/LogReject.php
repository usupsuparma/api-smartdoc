<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\LogWasReject;
use App\Modules\Log\Models\LogModel;
use Auth;

class LogReject
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
    public function handle(LogWasReject $event)
    { 
        $name = class_basename($event->actionLog);
        $model = str_replace('Model', '', $name);

        LogModel::create([
            'user_id' => Auth::user()->id,
            'model' => $model,
            'type' => 'rejected',
            'reference_id' => $event->actionLog->id,
            'activity' => "Melakukan pembatalan persetujuan pada data {$model} ",
            'visitor' => app('request')->ip()
        ]);
    }
}
