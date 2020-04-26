<?php namespace Modules\JsValidation\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Modules\JsValidation\Javascript\ValidatorHandler;
use Modules\JsValidation\Services\JsValidatorFactory;
use Modules\Support\Traits\ModuleServiceProvider;


/**
 * JsValidationServiceProvider class.
 *
 * @extends ServiceProvider
 */
class JsValidationServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'JsValidation';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'jsvalidation';

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
       //'backend.includes.sidebar' => \Modules\JsValidation\Http\Composers\Backend\Composer::class
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
        //\Modules\JsValidation\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        //\Modules\JsValidation\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
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

        $this->bootstrapValidator();

        if (mconfig('jsvalidation.config.disable_remote_validation') === false) {
            $this->app[Kernel::class]->pushMiddleware(\Modules\JsValidation\Http\Middleware\RemoteValidationMiddleware::class);
        }
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
        $this->app->singleton('jsvalidation', function ($app) {
            $config = mconfig('jsvalidation.config');

            return new JsValidatorFactory($app, $config);
        });
    }

    /**
     * Configure Laravel Validator.
     *
     * @return void
     */
    protected function bootstrapValidator()
    {
        $callback = function () {
            return true;
        };
        $this->app['validator']->extend(ValidatorHandler::JSVALIDATION_DISABLE, $callback);
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
