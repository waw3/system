<?php

namespace Modules\Plugins\MaintenanceMode\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Base\Supports\Helper;
use Illuminate\Routing\Events\RouteMatched;
use Event;
use Modules\Base\Traits\LoadAndPublishDataTrait;

class MaintenanceModeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('modules.plugins.maintenance-mode')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web'])
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-core-system-maintenance-mode',
                'priority'    => 700,
                'parent_id'   => 'cms-core-platform-administration',
                'name'        => 'modules.plugins.maintenance-mode::maintenance-mode.maintenance_mode',
                'icon'        => null,
                'url'         => route('system.maintenance.index'),
                'permissions' => ['superuser'],
            ]);
        });
    }
}
