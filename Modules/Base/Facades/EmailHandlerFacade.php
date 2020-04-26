<?php

namespace Modules\Base\Facades;

use Modules\Base\Supports\EmailHandler;
use Illuminate\Support\Facades\Facade;

class EmailHandlerFacade extends Facade
{

    /**
     * @return string
     *
     * @since 2.2
     */
    protected static function getFacadeAccessor()
    {
        return EmailHandler::class;
    }
}
