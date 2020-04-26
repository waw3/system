<?php

namespace Modules\SeoHelper\Facades;

use Modules\SeoHelper\Services\SeoHelper;
use Illuminate\Support\Facades\Facade;

/**
 * @since 02/12/2015 14:08 PM
 */
class SeoHelperFacade extends Facade
{

    /**
     * @return string
     *
     */
    protected static function getFacadeAccessor()
    {
        return SeoHelper::class;
    }
}
