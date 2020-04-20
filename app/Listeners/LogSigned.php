<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\LogWasSigned;
use App\Modules\Log\Models\LogModel;
use Auth;

class LogSigned
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
     * @param  LogWasSigned  $event
     * @return void
     */
    public function handle(LogWasSigned $event)
    { 
        $name = class_basename($event->actionLog);
        $model = str_replace('Model', '', $name);

        LogModel::create([
            'user_id' => Auth::user()->id,
            'model' => $model,
            'type' => 'signed',
            'reference_id' => $event->actionLog->id,
            'activity' => "Melakukan Tanda Tangan pada data {$model} ",
            'visitor' => app('request')->ip()
        ]);
    }
}
