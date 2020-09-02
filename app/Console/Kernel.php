<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CreateArchiveOutgoingCommand::class,
        Commands\CreateArchiveIncomingCommand::class,
        Commands\CreateArchiveDispositionCommand::class,
        Commands\ReplicateStructureCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('archive:outgoing')->timezone('Asia/Jakarta')
        ->at('01:00');
        $schedule->command('archive:incoming')->timezone('Asia/Jakarta')
        ->at('02:00');
        $schedule->command('archive:disposition')->timezone('Asia/Jakarta')
        ->at('03:00');
    }
}
