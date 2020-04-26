<?php namespace Modules\Optimize\Providers;

use Modules\Optimize\Http\Middleware\CollapseWhitespace;
use Modules\Optimize\Http\Middleware\ElideAttributes;
use Modules\Optimize\Http\Middleware\InlineCss;
use Modules\Optimize\Http\Middleware\InsertDNSPrefetch;
use Modules\Optimize\Http\Middleware\RemoveComments;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Modules\Support\Traits\ModuleServiceProvider;

/**
 * OptimizeServiceProvider class.
 *
 * @extends ServiceProvider
 */
class OptimizeServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Optimize';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'optimize';

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
        RouteServiceProvider::class,
        HookServiceProvider::class
    ];

    /**
     * Register the composer classes.
     *
     * @var array
     */
    protected $composerViews = [
       //'backend.includes.sidebar' => \Modules\Optimize\Http\Composers\Backend\Composer::class
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
        //\Modules\Optimize\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        //\Modules\Optimize\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
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

        /**
         * @var Router $router
         */
        $router = $this->app['router'];


        $router->pushMiddlewareToGroup('web', ElideAttributes::class);
        $router->pushMiddlewareToGroup('web', InsertDNSPrefetch::class);

        if (!$this->app->environment('local') && !is_in_admin()) {
            $router->pushMiddlewareToGroup('web', CollapseWhitespace::class);
        }

        $router->pushMiddlewareToGroup('web', RemoveComments::class);
        $router->pushMiddlewareToGroup('web', InlineCss::class);
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
