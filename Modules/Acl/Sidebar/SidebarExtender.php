<?php

namespace Modules\Acl\Sidebar;

use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Group;
use Modules\Dashboard\Sidebar\BaseSidebarExtender;
use Illuminate\Support\Facades\Auth;

class SidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {

        $menu->group(trans('modules.dashboard::sidebar.system'), function (Group $group) {
            $group->item(trans('modules.acl::sidebar.users'), function (Item $item) {
                $item->weight(5);
                $item->icon('fa fa-users');
                $item->route('users.index');
                $item->authorize(
                    Auth::user()->hasAnyPermission(['users.index', 'roles.index'])
                );

                // users
                $item->item(trans('modules.acl::sidebar.users'), function (Item $item) {
                    $item->weight(5);
                    $item->route('users.index');
                    $item->authorize(
                        Auth::user()->hasPermission('users.index')
                    );
                });

                // roles
                $item->item(trans('modules.acl::sidebar.roles'), function (Item $item) {
                    $item->weight(10);
                    $item->route('roles.index');
                    $item->authorize(
                        Auth::user()->hasPermission('roles.index')
                    );
                });
            });
        });
    }
}
