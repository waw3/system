<?php

namespace Modules\Plugins\Blog\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Modules\Theme\Events\RenderingSiteMapEvent::class => [
            \Modules\Plugins\Blog\Listeners\RenderingSiteMapListener::class,
        ],
    ];
}
