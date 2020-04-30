<?php

namespace Modules\Optimize\Providers;

use Illuminate\Support\ServiceProvider;
use Throwable;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        add_filter('base-filter-after-setting-content', [$this, 'addSetting'], 27, 1);
    }

    /**
     * @param null $data
     * @return string
     * @throws Throwable
     */
    public function addSetting($data = null)
    {
        return $data . view('modules.optimize::setting')->render();
    }
}
