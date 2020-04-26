<?php

namespace Modules\Plugins\RealEstate\Providers;

use Modules\Plugins\RealEstate\Commands\RenewPropertiesCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            RenewPropertiesCommand::class,
        ]);
    }
}
