<?php

namespace Modules\Dashboard\Sidebar;

use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Group;
use Illuminate\Support\Facades\Auth;

class SidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group(trans('modules.dashboard::sidebar.content'), function (Group $group) {
            $group->weight(5);
            $group->hideHeading();

            $group->item(trans('modules.dashboard::dashboard.dashboard'), function (Item $item) {
                $item->icon('fa fa-dashboard');
                $item->route('dashboard.index');
                $item->isActiveWhen(route('dashboard.index', null, false));
            });
        });

        $menu->group(trans('modules.dashboard::sidebar.system'), function (Group $group) {
            $group->weight(10);

            $group->item(trans('modules.dashboard::sidebar.appearance'), function (Item $item) {
                $item->icon('fa fa-paint-brush');
                $item->weight(15);
                $item->authorize(
                    Auth::user()->hasAnyPermission(['media.index', 'users.index'])
                );
            });
        });
    }
}
