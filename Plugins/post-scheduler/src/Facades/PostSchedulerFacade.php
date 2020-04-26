<?php

namespace Modules\Plugins\PostScheduler\Facades;

use Modules\Plugins\PostScheduler\Supports\PostScheduler;
use Illuminate\Support\Facades\Facade;

class PostSchedulerFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PostScheduler::class;
    }
}
