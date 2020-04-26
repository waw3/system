<?php

namespace Modules\Plugins\Captcha\Facades;

use Modules\Plugins\Captcha\Captcha;
use Illuminate\Support\Facades\Facade;

class CaptchaFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * 
     */
    protected static function getFacadeAccessor()
    {
        return Captcha::class;
    }
}
