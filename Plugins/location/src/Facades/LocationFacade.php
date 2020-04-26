<?php

namespace Modules\Plugins\Location\Facades;

use Modules\Plugins\Location\Location;
use Illuminate\Support\Facades\Facade;

class LocationFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Location::class;
    }
}
