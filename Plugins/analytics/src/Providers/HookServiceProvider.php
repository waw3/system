<?php

namespace Modules\Plugins\Analytics\Providers;

use Assets;
use Illuminate\Support\Facades\Auth;
use Modules\Dashboard\Supports\DashboardWidgetInstance;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Throwable;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        if (env('ANALYTICS_ENABLE_DASHBOARD_WIDGETS', true)) {
            add_action('dashboard_register_scripts', [$this, 'registerScripts'], 18);
            add_filter('admin_dashboard_list', [$this, 'addGeneralWidget'], 18, 2);
            add_filter('admin_dashboard_list', [$this, 'addPageWidget'], 19, 2);
            add_filter('admin_dashboard_list', [$this, 'addBrowserWidget'], 20, 2);
            add_filter('admin_dashboard_list', [$this, 'addReferrerWidget'], 22, 2);
            add_filter('base-filter-after-setting-content', [$this, 'addAnalyticsSetting'], 99, 1);
        }
    }

    /**
     * @return void
     *
     */
    public function registerScripts()
    {
        if (Auth::user()->hasAnyPermission([
            'analytics.general',
            'analytics.page',
            'analytics.browser',
            'analytics.referrer',
        ])) {
            Assets::addScripts(['jvectormap', 'raphael', 'morris'])
                ->addStyles(['jvectormap', 'morris'])
                ->addScriptsDirectly([
                    '/vendor/core/plugins/analytics/js/analytics.js',
                ]);
        }
    }

    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function addGeneralWidget($widgets, $widgetSettings)
    {
        return (new DashboardWidgetInstance)
            ->setPermission('analytics.general')
            ->setKey('widget_analytics_general')
            ->setTitle(trans('modules.plugins.analytics::analytics.widget_analytics_general'))
            ->setIcon('fas fa-chart-line')
            ->setColor('#f2784b')
            ->setRoute(route('analytics.general'))
            ->setBodyClass('row')
            ->setHasLoadCallback(true)
            ->setIsEqualHeight(false)
            ->init($widgets, $widgetSettings);
    }

    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function addPageWidget($widgets, $widgetSettings)
    {
        return (new DashboardWidgetInstance)
            ->setPermission('analytics.page')
            ->setKey('widget_analytics_page')
            ->setTitle(trans('modules.plugins.analytics::analytics.widget_analytics_page'))
            ->setIcon('far fa-newspaper')
            ->setColor('#3598dc')
            ->setRoute(route('analytics.page'))
            ->setBodyClass('scroll-table')
            ->setColumn('col-md-6 col-sm-6')
            ->init($widgets, $widgetSettings);
    }

    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function addBrowserWidget($widgets, $widgetSettings)
    {
        return (new DashboardWidgetInstance)
            ->setPermission('analytics.browser')
            ->setKey('widget_analytics_browser')
            ->setTitle(trans('modules.plugins.analytics::analytics.widget_analytics_browser'))
            ->setIcon('fab fa-safari')
            ->setColor('#8e44ad')
            ->setRoute(route('analytics.browser'))
            ->setBodyClass('scroll-table')
            ->setColumn('col-md-6 col-sm-6')
            ->init($widgets, $widgetSettings);
    }

    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function addReferrerWidget($widgets, $widgetSettings)
    {
        return (new DashboardWidgetInstance)
            ->setPermission('analytics.referrer')
            ->setKey('widget_analytics_referrer')
            ->setTitle(trans('modules.plugins.analytics::analytics.widget_analytics_referrer'))
            ->setIcon('fas fa-user-friends')
            ->setColor('#3598dc')
            ->setRoute(route('analytics.referrer'))
            ->setBodyClass('scroll-table')
            ->setColumn('col-md-6 col-sm-6')
            ->init($widgets, $widgetSettings);
    }

    /**
     * @param null $data
     * @return string
     * @throws Throwable
     */
    public function addAnalyticsSetting($data = null)
    {
        return $data . view('modules.plugins.analytics::setting')->render();
    }
}
