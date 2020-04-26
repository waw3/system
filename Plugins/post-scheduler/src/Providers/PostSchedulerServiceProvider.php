<?php

namespace Botble\PostScheduler\Providers;

use Modules\Base\Traits\LoadAndPublishDataTrait;
use Modules\Plugins\PostScheduler\Facades\PostSchedulerFacade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class PostSchedulerServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function boot()
    {
        if (is_plugin_active('blog')) {
            $this->setNamespace('modules.plugins.post-scheduler')
                ->loadAndPublishConfigurations(['general'])
                ->loadAndPublishTranslations()
                ->loadAndPublishViews();

            AliasLoader::getInstance()->alias('PostScheduler', PostSchedulerFacade::class);

            $this->app->register(HookServiceProvider::class);
        }
    }
}
