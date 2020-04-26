<?php

namespace Modules\Plugins\CustomField\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Plugins\CustomField\Support\CustomFieldSupport;

class CustomFieldSupportFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CustomFieldSupport::class;
    }
}
