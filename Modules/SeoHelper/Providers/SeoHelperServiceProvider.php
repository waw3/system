<?php namespace Modules\SeoHelper\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Support\Traits\ModuleServiceProvider;



/**
 * SeoHelperServiceProvider class.
 *
 * @extends ServiceProvider
 */
class SeoHelperServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'SeoHelper';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'seohelper';

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
        RouteServiceProvider::class
    ];

    /**
     * Register the composer classes.
     *
     * @var array
     */
    protected $composerViews = [
       //'backend.includes.sidebar' => \Modules\SeoHelper\Http\Composers\Backend\Composer::class
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
        \Modules\Base\Events\UpdatedContentEvent::class => [
            \Modules\SeoHelper\Listeners\UpdatedContentListener::class,
        ],
        \Modules\Base\Events\CreatedContentEvent::class => [
            \Modules\SeoHelper\Listeners\CreatedContentListener::class,
        ],
        \Modules\Base\Events\DeletedContentEvent::class => [
            \Modules\SeoHelper\Listeners\DeletedContentListener::class,
        ],
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
        //\Modules\SeoHelper\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        //\Modules\SeoHelper\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
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
        $this->app->bind(\Modules\SeoHelper\Contracts\SeoMetaContract::class, \Modules\SeoHelper\Services\SeoMeta::class);
        $this->app->bind(\Modules\SeoHelper\Contracts\SeoHelperContract::class, \Modules\SeoHelper\Services\SeoHelper::class);
        $this->app->bind(\Modules\SeoHelper\Contracts\SeoOpenGraphContract::class, \Modules\SeoHelper\Services\SeoOpenGraph::class);
        $this->app->bind(\Modules\SeoHelper\Contracts\SeoTwitterContract::class, \Modules\SeoHelper\Services\SeoTwitter::class);
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
