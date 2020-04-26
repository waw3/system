<?php

namespace Modules\Plugins\LogViewer\Providers;

use Modules\Plugins\LogViewer\LogViewer;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Supports\Helper;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Event;
use Illuminate\Support\ServiceProvider;
use Modules\Plugins\LogViewer\Contracts;
use Modules\Plugins\LogViewer\Utilities;

class LogViewerServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind('botble::log-viewer', LogViewer::class);

        Helper::autoload(__DIR__ . '/../../helpers');

        $this->app->singleton('botble::log-viewer.levels', function ($app) {
            return new Utilities\LogLevels($app['translator'], config('modules.plugins.log-viewer.general.locale'));
        });
        $this->app->bind(Contracts\Utilities\LogLevels::class, 'botble::log-viewer.levels');

        $this->app->singleton('botble::log-viewer.styler', Utilities\LogStyler::class);
        $this->app->bind(Contracts\Utilities\LogStyler::class, 'botble::log-viewer.styler');

        $this->app->singleton('botble::log-viewer.menu', Utilities\LogMenu::class);
        $this->app->bind(Contracts\Utilities\LogMenu::class, 'botble::log-viewer.menu');

        $this->app->singleton('botble::log-viewer.filesystem', function ($app) {
            $filesystem = new Utilities\Filesystem($app['files'], config('modules.plugins.log-viewer.general.storage-path'));

            $filesystem->setPattern(
                config('modules.plugins.log-viewer.general.pattern.prefix', Utilities\Filesystem::PATTERN_PREFIX),
                config('modules.plugins.log-viewer.general.pattern.date', Utilities\Filesystem::PATTERN_DATE),
                config('modules.plugins.log-viewer.general.pattern.extension', Utilities\Filesystem::PATTERN_EXTENSION)
            );

            return $filesystem;
        });
        $this->app->bind(Contracts\Utilities\Filesystem::class, 'botble::log-viewer.filesystem');

        $this->app->singleton('botble::log-viewer.factory', Utilities\Factory::class);
        $this->app->bind(Contracts\Utilities\Factory::class, 'botble::log-viewer.factory');

        $this->app->singleton('botble::log-viewer.checker', Utilities\LogChecker::class);
        $this->app->bind(Contracts\Utilities\LogChecker::class, 'botble::log-viewer.checker');
    }

    public function boot()
    {
        $this->setNamespace('modules.plugins.log-viewer')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugin-system-logs',
                'priority'    => 7,
                'parent_id'   => 'cms-core-platform-administration',
                'name'        => 'modules.plugins.log-viewer::log-viewer.menu_name',
                'icon'        => null,
                'url'         => route('log-viewer::logs.index'),
                'permissions' => ['logs.index'],
            ]);
        });
    }
}
