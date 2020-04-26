<?php

namespace Modules\Theme\Facades;

use Modules\Theme\Services\Theme;
use Illuminate\Support\Facades\Facade;

class ThemeFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     */
    protected static function getFacadeAccessor()
    {
        return Theme::class;
    }
}
