<?php

namespace Modules\Plugins\Language\Facades;

use Modules\Plugins\Language\LanguageManager;
use Illuminate\Support\Facades\Facade;

class LanguageFacade extends Facade
{

    /**
     * @return string
     *
     */
    protected static function getFacadeAccessor()
    {
        return LanguageManager::class;
    }
}
