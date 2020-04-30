<?php

namespace Modules\Dashboard\Facades;

use Illuminate\Support\Facades\Facade;

class DashboardMenu extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dashboardmenu';
    }
}
