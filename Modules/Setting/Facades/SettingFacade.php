<?php

namespace Modules\Setting\Facades;

use Modules\Setting\Supports\SettingStore;
use Illuminate\Support\Facades\Facade;

class SettingFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SettingStore::class;
    }
}
