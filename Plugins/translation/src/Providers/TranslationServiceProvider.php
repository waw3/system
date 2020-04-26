<?php

namespace Modules\Plugins\Translation\Providers;

use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Modules\Plugins\Translation\Console\CleanCommand;
use Modules\Plugins\Translation\Console\ExportCommand;
use Modules\Plugins\Translation\Console\FindCommand;
use Modules\Plugins\Translation\Console\ImportCommand;
use Modules\Plugins\Translation\Console\ResetCommand;
use Modules\Plugins\Translation\Manager;
use Event;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind('translation-manager', Manager::class);

        $this->commands([
            ImportCommand::class,
            FindCommand::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ResetCommand::class,
                ExportCommand::class,
                CleanCommand::class,
            ]);
        }
    }

    public function boot()
    {
        $this->setNamespace('modules.plugins.translation')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadMigrations()
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugin-translation',
                'priority'    => 6,
                'parent_id'   => 'cms-core-platform-administration',
                'name'        => 'modules.plugins.translation::translation.menu_name',
                'icon'        => null,
                'url'         => route('translations.index'),
                'permissions' => ['translations.index'],
            ]);
        });
    }
}
