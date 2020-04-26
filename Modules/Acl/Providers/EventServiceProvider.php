<?php

namespace Modules\Acl\Providers;

use Modules\Acl\Events\RoleAssignmentEvent;
use Modules\Acl\Events\RoleUpdateEvent;
use Modules\Acl\Listeners\LoginListener;
use Modules\Acl\Listeners\RoleAssignmentListener;
use Modules\Acl\Listeners\RoleUpdateListener;
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
        RoleUpdateEvent::class     => [
            RoleUpdateListener::class,
        ],
        RoleAssignmentEvent::class => [
            RoleAssignmentListener::class,
        ],
        Login::class               => [
            LoginListener::class,
        ],
    ];
}
