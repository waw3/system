<?php

namespace Modules\Plugins\Analytics\Facades;

use Modules\Plugins\Analytics\Analytics;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Modules\Plugins\Analytics\Analytics
 */
class AnalyticsFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Analytics::class;
    }
}
