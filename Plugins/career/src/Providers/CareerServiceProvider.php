<?php

namespace Modules\Plugins\Career\Providers;

use Modules\Plugins\Career\Models\Career;
use Illuminate\Support\ServiceProvider;
use Modules\Plugins\Career\Repositories\Caches\CareerCacheDecorator;
use Modules\Plugins\Career\Repositories\Eloquent\CareerRepository;
use Modules\Plugins\Career\Repositories\Interfaces\CareerInterface;
use Modules\Base\Supports\Helper;
use Event;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use Language;
use SeoHelper;
use SlugHelper;

class CareerServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    public function register()
    {
        $this->app->bind(CareerInterface::class, function () {
            return new CareerCacheDecorator(new CareerRepository(new Career));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('modules.plugins.career')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-career',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'modules.plugins.career::career.name',
                'icon'        => 'far fa-newspaper',
                'url'         => route('career.index'),
                'permissions' => ['career.index'],
            ]);
        });

        $modules = [Career::class];
        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            Language::registerModule($modules);
        }

        $this->app->booted(function () use ($modules) {
            SlugHelper::registerModule($modules);
            SlugHelper::setPrefix(Career::class, 'careers');

            SeoHelper::registerModule($modules);
        });
    }
}
