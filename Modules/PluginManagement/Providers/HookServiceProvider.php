<?php

namespace Modules\PluginManagement\Providers;

use Modules\Dashboard\Supports\DashboardWidgetInstance;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Throwable;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        add_filter('admin_dashboard_list', [$this, 'addStatsWidgets'], 15, 2);
    }

    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function addStatsWidgets($widgets, $widgetSettings)
    {
        $plugins = count(scan_folder(plugin_path()));

        return (new DashboardWidgetInstance)
            ->setType('stats')
            ->setPermission('plugins.index')
            ->setTitle(trans('modules.pluginmanagement::plugin.plugins'))
            ->setKey('widget_total_plugins')
            ->setIcon('fa fa-plug')
            ->setColor('#8e44ad')
            ->setStatsTotal($plugins)
            ->setRoute(route('plugins.index'))
            ->init($widgets, $widgetSettings);
    }
}
