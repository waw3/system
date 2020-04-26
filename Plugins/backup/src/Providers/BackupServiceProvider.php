<?php

namespace Modules\Plugins\Backup\Providers;

use Modules\Base\Supports\Helper;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Event;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;

class BackupServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('modules.plugins.backup')
            ->loadAndPublishConfigurations(['permissions', 'general'])
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugin-backup',
                'priority'    => 8,
                'parent_id'   => 'cms-core-platform-administration',
                'name'        => 'modules.plugins.backup::backup.menu_name',
                'icon'        => null,
                'url'         => route('backups.index'),
                'permissions' => ['backups.index'],
            ]);
        });
    }
}
