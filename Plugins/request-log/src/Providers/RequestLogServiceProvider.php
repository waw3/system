<?php

namespace Modules\Plugins\RequestLog\Providers;

use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Supports\Helper;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Modules\Plugins\RequestLog\Repositories\Caches\RequestLogCacheDecorator;
use Modules\Plugins\RequestLog\Repositories\Eloquent\RequestLogRepository;
use Modules\Plugins\RequestLog\Repositories\Interfaces\RequestLogInterface;
use Event;
use Illuminate\Support\ServiceProvider;
use Modules\Plugins\RequestLog\Models\RequestLog as RequestLogModel;

/**
 * @since 02/07/2016 09:50 AM
 */
class RequestLogServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(RequestLogInterface::class, function () {
            return new RequestLogCacheDecorator(new RequestLogRepository(new RequestLogModel));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);

        $this->setNamespace('modules.plugins.request-log')
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-plugin-request-log',
                    'priority'    => 8,
                    'parent_id'   => 'cms-core-platform-administration',
                    'name'        => 'modules.plugins.request-log::request-log.name',
                    'icon'        => null,
                    'url'         => route('request-log.index'),
                    'permissions' => ['request-log.index'],
                ]);
        });
    }
}
