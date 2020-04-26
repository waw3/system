<?php

namespace Modules\Plugins\RequestLog\Providers;

use Modules\Plugins\RequestLog\Events\RequestHandlerEvent;
use Modules\Plugins\RequestLog\Listeners\RequestHandlerListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RequestHandlerEvent::class => [
            RequestHandlerListener::class,
        ],
    ];
}
