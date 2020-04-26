<?php

namespace Modules\Base\Facades;

use Modules\Base\Supports\Assets;
use Illuminate\Support\Facades\Facade;

class AssetsFacade extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Assets::class;
    }
}
