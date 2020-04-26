<?php

namespace Modules\Plugins\Location\Providers;

use Modules\Plugins\Location\Facades\LocationFacade;
use Modules\Plugins\Location\Models\City;
use Modules\Plugins\Location\Repositories\Caches\CityCacheDecorator;
use Modules\Plugins\Location\Repositories\Eloquent\CityRepository;
use Modules\Plugins\Location\Repositories\Interfaces\CityInterface;
use Modules\Plugins\Location\Models\Country;
use Modules\Plugins\Location\Repositories\Caches\CountryCacheDecorator;
use Modules\Plugins\Location\Repositories\Eloquent\CountryRepository;
use Modules\Plugins\Location\Repositories\Interfaces\CountryInterface;
use Modules\Plugins\Location\Models\State;
use Modules\Plugins\Location\Repositories\Caches\StateCacheDecorator;
use Modules\Plugins\Location\Repositories\Eloquent\StateRepository;
use Modules\Plugins\Location\Repositories\Interfaces\StateInterface;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Modules\Base\Supports\Helper;
use Event;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use Language;

class LocationServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @var Application
     */
    protected $app;

    public function register()
    {
        $this->app->bind(CountryInterface::class, function () {
            return new CountryCacheDecorator(new CountryRepository(new Country));
        });

        $this->app->bind(StateInterface::class, function () {
            return new StateCacheDecorator(new StateRepository(new State));
        });

        $this->app->bind(CityInterface::class, function () {
            return new CityCacheDecorator(new CityRepository(new City));
        });

        Helper::autoload(__DIR__ . '/../../helpers');

        AliasLoader::getInstance()->alias('Location', LocationFacade::class);
    }

    public function boot()
    {
        $this->setNamespace('modules.plugins.location')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web'])
            ->publishAssets();

        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            Language::registerModule([
                Country::class,
                State::class,
                City::class,
            ]);
        }

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-plugins-location',
                    'priority'    => 5,
                    'parent_id'   => null,
                    'name'        => 'modules.plugins.location::location.name',
                    'icon'        => 'fas fa-globe',
                    'url'         => null,
                    'permissions' => ['country.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-country',
                    'priority'    => 0,
                    'parent_id'   => 'cms-plugins-location',
                    'name'        => 'modules.plugins.location::country.name',
                    'icon'        => null,
                    'url'         => route('country.index'),
                    'permissions' => ['country.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-state',
                    'priority'    => 1,
                    'parent_id'   => 'cms-plugins-location',
                    'name'        => 'modules.plugins.location::state.name',
                    'icon'        => null,
                    'url'         => route('state.index'),
                    'permissions' => ['state.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-city',
                    'priority'    => 2,
                    'parent_id'   => 'cms-plugins-location',
                    'name'        => 'modules.plugins.location::city.name',
                    'icon'        => null,
                    'url'         => route('city.index'),
                    'permissions' => ['city.index'],
                ]);
        });
    }
}
