<?php

namespace Modules\Language\Facades;

use Modules\Language\Services\LanguageManager;
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
