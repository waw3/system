<?php

namespace Modules\Plugins\AuditLog\Providers;

use Modules\Plugins\AuditLog\Events\AuditHandlerEvent;
use Modules\Plugins\AuditLog\Listeners\AuditHandlerListener;
use Modules\Plugins\AuditLog\Listeners\CreatedContentListener;
use Modules\Plugins\AuditLog\Listeners\DeletedContentListener;
use Modules\Plugins\AuditLog\Listeners\LoginListener;
use Modules\Plugins\AuditLog\Listeners\UpdatedContentListener;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AuditHandlerEvent::class   => [
            AuditHandlerListener::class,
        ],
        Login::class               => [
            LoginListener::class,
        ],
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
        CreatedContentEvent::class => [
            CreatedContentListener::class,
        ],
        DeletedContentEvent::class => [
            DeletedContentListener::class,
        ],
    ];
}
