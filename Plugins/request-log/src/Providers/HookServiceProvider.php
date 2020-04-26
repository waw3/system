<?php

namespace Modules\Plugins\RequestLog\Providers;

use Assets;
use Illuminate\Support\Facades\Auth;
use Modules\Dashboard\Supports\DashboardWidgetInstance;
use Modules\Plugins\RequestLog\Events\RequestHandlerEvent;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Throwable;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        add_action(BASE_ACTION_SITE_ERROR, [$this, 'handleSiteError'], 125, 1);
        add_filter('admin_dashboard_list', [$this, 'registerDashboardWidgets'], 125, 2);
    }

    /**
     * Fire event log
     *
     * @param int $code
     */
    public function handleSiteError($code)
    {
        event(new RequestHandlerEvent($code));
    }

    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function registerDashboardWidgets($widgets, $widgetSettings)
    {
        if (!Auth::user()->hasPermission('request-log.index')) {
            return $widgets;
        }

        Assets::addScriptsDirectly(['vendor/core/plugins/request-log/js/request-log.js']);

        return (new DashboardWidgetInstance)
            ->setPermission('request-log.index')
            ->setKey('widget_request_errors')
            ->setTitle(trans('modules.plugins.request-log::request-log.widget_request_errors'))
            ->setIcon('fas fa-unlink')
            ->setColor('#e7505a')
            ->setRoute(route('request-log.widget.request-errors'))
            ->setBodyClass('scroll-table')
            ->setColumn('col-md-6 col-sm-6')
            ->init($widgets, $widgetSettings);
    }
}
