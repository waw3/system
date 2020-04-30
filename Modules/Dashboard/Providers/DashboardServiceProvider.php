<?php namespace Modules\Dashboard\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Modules\Base\Supports\Helper;
use Modules\Support\Traits\ModuleServiceProvider;
use Modules\Dashboard\Models\DashboardWidget;
use Modules\Dashboard\Models\DashboardWidgetSetting;
use Modules\Dashboard\Repositories\Caches\DashboardWidgetCacheDecorator;
use Modules\Dashboard\Repositories\Caches\DashboardWidgetSettingCacheDecorator;
use Modules\Dashboard\Repositories\Eloquent\DashboardWidgetRepository;
use Modules\Dashboard\Repositories\Eloquent\DashboardWidgetSettingRepository;
use Modules\Dashboard\Repositories\Interfaces\DashboardWidgetInterface;
use Modules\Dashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;


/**
 * DashboardServiceProvider class.
 *
 * @extends ServiceProvider
 */
class DashboardServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Dashboard';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'dashboard';

    /**
     * aliases
     *
     * @var mixed
     * @access protected
     */
    protected $aliases = [
        'DashboardMenu' => Modules\Dashboard\Facades\DashboardMenu::class
    ];

    /**
     * providers
     *
     * @var mixed
     * @access protected
     */
    protected $providers = [
        RouteServiceProvider::class
    ];

    /**
     * Register the composer classes.
     *
     * @var array
     */
    protected $composerViews = [
       //'backend.includes.sidebar' => \Modules\Dashboard\Http\Composers\Backend\Composer::class
    ];

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //
    ];

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //
    ];

    /**
     * Class event subscribers.
     *
     * @var array
     */
    protected $subscribe = [
        //
    ];

    /**
     * The command mappings for the application.
     *
     * @var array
     */
    protected $commands = [
        //\Modules\Dashboard\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        //\Modules\Dashboard\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
    ];

    /**
     * The application's global middleware groups.
     *
     * @var array
     */
    protected $middleware = [
        //
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
       //
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
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
                    'id'          => 'cms-core-dashboard',
                    'priority'    => 0,
                    'parent_id'   => null,
                    'name'        => 'modules.base::layouts.dashboard',
                    'icon'        => 'fa fa-home',
                    'url'         => route('dashboard.index'),
                    'permissions' => [],
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
        $this->app->singleton('isInstalled', function () {
            return $this->isInstalled();
        });

        $this->app->singleton('onBackend', function () {
            return $this->onBackend();
        });

        $this->app->bind('dashboardmenu', \Modules\Dashboard\Supports\DashboardMenu::class);

        $this->app->bind(DashboardWidgetInterface::class, function () {
            return new DashboardWidgetCacheDecorator(
                new DashboardWidgetRepository(new DashboardWidget)
            );
        });

        $this->app->bind(DashboardWidgetSettingInterface::class, function () {
            return new DashboardWidgetSettingCacheDecorator(
                new DashboardWidgetSettingRepository(new DashboardWidgetSetting)
            );
        });
    }


    private function isInstalled()
    {
        return true === mconfig('base.config.installed');
    }

     /**
     * Checks if the current url matches the configured backend uri
     * @return bool
     */
    private function onBackend()
    {
        $url = app(Request::class)->path();
        if (str_contains($url, mconfig('base.config.admin_dir'))) {
            return true;
        }

        return false;
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
