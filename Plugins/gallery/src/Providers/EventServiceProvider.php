<?php

namespace Modules\Plugins\Gallery\Providers;

use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Theme\Events\RenderingSiteMapEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Plugins\Gallery\Listeners\CreatedContentListener;
use Modules\Plugins\Gallery\Listeners\DeletedContentListener;
use Modules\Plugins\Gallery\Listeners\RenderingSiteMapListener;
use Modules\Plugins\Gallery\Listeners\UpdatedContentListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RenderingSiteMapEvent::class => [
            RenderingSiteMapListener::class,
        ],
        UpdatedContentEvent::class   => [
            UpdatedContentListener::class,
        ],
        CreatedContentEvent::class   => [
            CreatedContentListener::class,
        ],
        DeletedContentEvent::class   => [
            DeletedContentListener::class,
        ],
    ];
}
