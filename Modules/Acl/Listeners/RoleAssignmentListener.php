<?php

namespace Modules\Acl\Listeners;

use Exception;
use Illuminate\Support\Facades\Auth;
use Modules\Acl\Events\RoleAssignmentEvent;

class RoleAssignmentListener
{

    /**
     * Handle the event.
     *
     * @param RoleAssignmentEvent $event
     * @return void
     *
     * @throws Exception
     */
    public function handle(RoleAssignmentEvent $event)
    {
        $permissions = $event->role->permissions;
        $permissions['superuser'] = $event->user->super_user;
        $permissions['manage_supers'] = $event->user->manage_supers;

        $event->user->permissions = $permissions;
        $event->user->save();

        cache()->forget(md5('cache-dashboard-menu-' . Auth::user()->getKey()));
    }
}
