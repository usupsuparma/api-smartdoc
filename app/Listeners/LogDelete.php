<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\LogWasDelete;
use App\Modules\Log\Models\LogModel;
use Auth;

class LogDelete
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
     * @param  LogWasDelete  $event
     * @return void
     */
    public function handle(LogWasDelete $event)
    {    
        $name = class_basename($event->actionLog);
        $model = str_replace('Model', '', $name);

        LogModel::create([
            'user_id' => Auth::user()->id,
            'model' => $model,
            'type' => 'deleted',
            'reference_id' => $event->actionLog->id,
            'activity' => "Melakukan penghapusan pada data {$model} ",
            'visitor' => app('request')->ip()
        ]);
    }
}
