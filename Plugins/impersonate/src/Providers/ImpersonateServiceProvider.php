<?php

namespace Modules\Plugins\Impersonate\Providers;

use Modules\Plugins\Impersonate\Models\User;
use Illuminate\Support\ServiceProvider;
use Modules\Base\Traits\LoadAndPublishDataTrait;

class ImpersonateServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot()
    {
        $this->setNamespace('modules.plugins.impersonate')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        config()->set(['auth.providers.users.model' => User::class]);

        $this->app->register(HookServiceProvider::class);
    }
}
