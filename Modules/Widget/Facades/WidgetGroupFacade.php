<?php

namespace Modules\Widget\Facades;

use Illuminate\Support\Facades\Facade;

class WidgetGroupFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'modules.widget-group-collection';
    }
}
