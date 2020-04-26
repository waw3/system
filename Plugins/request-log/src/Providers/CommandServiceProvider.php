<?php

namespace Modules\Plugins\RequestLog\Providers;

use Modules\Plugins\RequestLog\Commands\RequestLogClearCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RequestLogClearCommand::class,
            ]);
        }
    }
}
