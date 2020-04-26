<?php

namespace Modules\Slug\Facades;

use Modules\Slug\Services\SlugHelper;
use Illuminate\Support\Facades\Facade;

class SlugHelperFacade extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SlugHelper::class;
    }
}
