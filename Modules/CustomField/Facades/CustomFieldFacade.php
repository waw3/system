<?php

namespace Modules\CustomField\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\CustomField\Services\CustomField;

class CustomFieldFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CustomField::class;
    }
}
