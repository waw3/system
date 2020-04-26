<?php

namespace Modules\Plugins\RequestLog;

use Modules\PluginManagement\Abstracts\PluginOperationAbstract;
use Modules\Dashboard\Repositories\Interfaces\DashboardWidgetInterface;
use Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('request_logs');
        app(DashboardWidgetInterface::class)->deleteBy(['name' => 'widget_request_errors']);
    }
}
