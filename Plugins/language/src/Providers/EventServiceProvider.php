<?php

namespace Modules\Plugins\Language\Providers;

use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Plugins\Language\Listeners\CreatedContentListener;
use Modules\Plugins\Language\Listeners\DeletedContentListener;
use Modules\Plugins\Language\Listeners\ThemeRemoveListener;
use Modules\Plugins\Language\Listeners\UpdatedContentListener;
use Modules\Theme\Events\ThemeRemoveEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
        CreatedContentEvent::class => [
            CreatedContentListener::class,
        ],
        DeletedContentEvent::class => [
            DeletedContentListener::class,
        ],
        ThemeRemoveEvent::class    => [
            ThemeRemoveListener::class,
        ],
    ];
}
