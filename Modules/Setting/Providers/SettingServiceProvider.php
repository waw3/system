<?php namespace Modules\Setting\Providers;

use Modules\Setting\Models\Setting as SettingModel;
use Modules\Setting\Repositories\Caches\SettingCacheDecorator;
use Modules\Setting\Repositories\Eloquent\SettingRepository;
use Modules\Setting\Repositories\Interfaces\SettingInterface;
use Modules\Setting\Supports\SettingsManager;
use Modules\Setting\Supports\SettingStore;
use Event;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Modules\Support\Traits\ModuleServiceProvider;

/**
 * SettingServiceProvider class.
 *
 * @extends ServiceProvider
 */
class SettingServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Setting';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'setting';

    /**
     * aliases
     *
     * @var mixed
     * @access protected
     */
    protected $aliases = [
        //
    ];

    /**
     * providers
     *
     * @var mixed
     * @access protected
     */
    protected $providers = [
        //
    ];


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootModule();


        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-core-settings',
                    'priority'    => 998,
                    'parent_id'   => null,
                    'name'        => 'modules.setting::setting.title',
                    'icon'        => 'fa fa-cogs',
                    'url'         => route('settings.options'),
                    'permissions' => ['settings.options'],
                ])
                ->registerItem([
                    'id'          => 'cms-core-settings-general',
                    'priority'    => 1,
                    'parent_id'   => 'cms-core-settings',
                    'name'        => 'modules.base::layouts.setting_general',
                    'icon'        => null,
                    'url'         => route('settings.options'),
                    'permissions' => ['settings.options'],
                ])
                ->registerItem([
                    'id'          => 'cms-core-settings-email',
                    'priority'    => 2,
                    'parent_id'   => 'cms-core-settings',
                    'name'        => 'modules.base::layouts.setting_email',
                    'icon'        => null,
                    'url'         => route('settings.email'),
                    'permissions' => ['settings.email'],
                ])
                ->registerItem([
                    'id'          => 'cms-core-settings-media',
                    'priority'    => 3,
                    'parent_id'   => 'cms-core-settings',
                    'name'        => 'modules.setting::setting.media.title',
                    'icon'        => null,
                    'url'         => route('settings.media'),
                    'permissions' => ['settings.media'],
                ]);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerModule();

    }


    /**
     * registerBinders function.
     *
     * @access private
     * @return void
     */
    private function registerBinders()
    {
        $this->app->bind(SettingInterface::class, function () {
            return new SettingCacheDecorator(
                new SettingRepository(new SettingModel)
            );
        });

        $this->app->singleton(SettingsManager::class, function (Application $app) {
            return new SettingsManager($app);
        });

        $this->app->bind(SettingStore::class, function (Application $app) {
            return $app->make(SettingsManager::class)->driver();
        });
    }



    /**
     * Which IoC bindings the provider provides.
     *
     * @return array
     */
    public function provides()
    {
        return [
            SettingsManager::class,
            SettingStore::class,
            'setting',
        ];
    }
}
