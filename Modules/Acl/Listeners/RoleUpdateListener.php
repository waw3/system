<?php

namespace Modules\Acl\Listeners;

use Exception;
use Illuminate\Support\Facades\Auth;
use Modules\Acl\Events\RoleUpdateEvent;

class RoleUpdateListener
{
    /**
     * Handle the event.
     *
     * @param RoleUpdateEvent $event
     * @return void
     *
     * @throws Exception
     */
    public function handle(RoleUpdateEvent $event)
    {
        $permissions = $event->role->permissions;
        foreach ($event->role->users()->get() as $user) {
            $permissions['superuser'] = $user->super_user;
            $permissions['manage_supers'] = $user->manage_supers;

            $user->permissions = $permissions;
            $user->save();
        }

        cache()->forget(md5('cache-dashboard-menu-' . Auth::user()->getKey()));
    }
}
