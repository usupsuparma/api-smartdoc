<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ExampleEvent' => [
            'App\Listeners\ExampleListener',
        ],
        'App\Events\LogWasCreate' => [
            'App\Listeners\LogCreate',
        ],
        'App\Events\LogWasDelete' => [
            'App\Listeners\LogDelete',
        ],
        'App\Events\LogWasUpdate' => [
            'App\Listeners\LogUpdate',
        ],
        'App\Events\LogWasDisposition' => [
            'App\Listeners\LogDisposition',
        ],
        'App\Events\LogWasApprove' => [
            'App\Listeners\LogApprove',
        ],
        'App\Events\LogWasPublish' => [
            'App\Listeners\LogPublish',
        ]
    ];
}
