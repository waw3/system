<?php namespace Modules\Base\Providers;

use Event, MetaBox, File;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\ResourceRegistrar;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Base\Exceptions\Handler;
use Modules\Base\Models\MetaBox as MetaBoxModel;
use Modules\Base\Repositories\Caches\MetaBoxCacheDecorator;
use Modules\Base\Repositories\Eloquent\MetaBoxRepository;
use Modules\Base\Repositories\Interfaces\MetaBoxInterface;
use Modules\Base\Supports\CustomResourceRegistrar;
use Modules\Base\Supports\Helper;
use Modules\Setting\Providers\SettingServiceProvider;
use Modules\Setting\Supports\SettingStore;
use Modules\Support\Traits\ModuleServiceProvider;
use Modules\Base\Traits\CanGetSidebarClassForModule;

/**
 * BaseServiceProvider class.
 *
 * @extends ServiceProvider
 */
class BaseServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider, CanGetSidebarClassForModule;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Base';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'base';

    /**
     * aliases
     *
     * @var mixed
     * @access protected
     */
    protected $aliases = [

    ];

    /**
     * providers
     *
     * @var mixed
     * @access protected
     */
    protected $providers = [
        \Modules\Setting\Providers\SettingServiceProvider::class,
    ];

    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        //
    ];

    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        ExceptionHandler::class => Handler::class
    ];

    /**
     * Register the composer classes.
     *
     * @var array
     */
    protected $composerViews = [
       //'backend.includes.sidebar' => \Modules\Base\Http\Composers\Backend\Composer::class
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
        SendMailEvent::class            => [SendMailListener::class],
        CreatedContentEvent::class      => [CreatedContentListener::class],
        UpdatedContentEvent::class      => [UpdatedContentListener::class],
        DeletedContentEvent::class      => [DeletedContentListener::class],
        BeforeEditContentEvent::class   => [BeforeEditContentListener::class]
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
        \Modules\Base\Console\Commands\ClearLogCommand::class => 'command.cms:log:clear'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        //\Modules\Base\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
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

    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'preventDemo' => \Modules\Base\Http\Middleware\DisableInDemoModeMiddleware::class
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            do_action('init');
            add_action('meta_boxes', [MetaBox::class, 'doMetaBoxes'], 8, 2);

            config([
                'app.locale' => mconfig('base.config.locale', config('app.locale')),
                'purifier.settings.default.AutoFormat.AutoParagraph' => false,
                'purifier.settings.default.AutoFormat.RemoveEmpty'   => false,
            ]);

        });



        $this->bootModule();



    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        foreach (config('constants') as $constant => $value) {
            defined($constant) or define($constant, $value);
        }

        $this->registerGlobalModuleDependents();

        $this->registerModule();



        $router = $this->app['router'];

        $router->pushMiddlewareToGroup('web', \Modules\Base\Http\Middleware\LocaleMiddleware::class);
        $router->pushMiddlewareToGroup('web', \Modules\Base\Http\Middleware\HttpsProtocolMiddleware::class);

        $setting = $this->app->make(SettingStore::class);

        config([
            'app.timezone'                     => $setting->get('time_zone', config('app.timezone')),
            'ziggy.blacklist'                  => ['debugbar.*'],
            'session.cookie'                   => 'kracken_session',
            'filesystems.default'              => $setting->get('media_driver', config('filesystems.default')),
            'filesystems.disks.s3.key'         => $setting->get('media_aws_access_key_id', config('filesystems.disks.s3.key')),
            'filesystems.disks.s3.secret'      => $setting->get('media_aws_secret_key', config('filesystems.disks.s3.secret')),
            'filesystems.disks.s3.region'      => $setting->get('media_aws_default_region', config('filesystems.disks.s3.region')),
            'filesystems.disks.s3.bucket'      => $setting->get('media_aws_bucket', config('filesystems.disks.s3.bucket')),
            'filesystems.disks.s3.url'         => $setting->get('media_aws_url', config('filesystems.disks.s3.url')),
            'datatables-buttons.pdf_generator' => 'excel',
        ]);

        Event::listen(RouteMatched::class, function () {
            $this->registerDefaultMenus();
        });

        Event::listen(['cache:cleared'], function () {
            File::delete([storage_path('cache_keys.json'), storage_path('settings.json')]);
        });


/*
        $this->app['events']->listen(
            \Modules\Base\Events\BuildingSidebar::class,
            $this->getSidebarClassForModule('core', \Modules\Core\Events\Handlers\RegisterCoreSidebar::class)
        );
*/


    }


    /**
     * registerBinders function.
     *
     * @access private
     * @return void
     */
    private function registerBinders()
    {

        $this->app->bind(ResourceRegistrar::class, function ($app) {
            return new CustomResourceRegistrar($app['router']);
        });

        $this->app->bind(MetaBoxInterface::class, function () {
            return new MetaBoxCacheDecorator(new MetaBoxRepository(new MetaBoxModel));
        });
    }

    /**
     * registerGlobalModuleDependents function.
     *
     * @access private
     * @return void
     */
    private function registerGlobalModuleDependents()
    {

/*

        foreach ($this->app['modules']->getOrdered() as $module) {
            echo $module->getAlias() . ' = ' . $module->getLowerName() . '<br>';

        }

        dd($this->app['modules']->getOrdered());
*/

        foreach ($this->app['modules']->getOrdered() as $module) {
            $this->registerModuleConfig($module);
            $this->registerModuleMigration($module);
            $this->registerModuleFactories($module);
            $this->registerModulePublicAssets($module);

            $this->registerModuleViewNamespace($module);
            $this->registerModuleLanguageNamespace($module);
        }
    }

    /**
     * Add default dashboard menu for core
     */
    public function registerDefaultMenus()
    {
        dashboard_menu()
            ->registerItem([
                'id'          => 'cms-core-platform-administration',
                'priority'    => 999,
                'parent_id'   => null,
                'name'        => 'modules.base::layouts.platform_admin',
                'icon'        => 'fa fa-user-shield',
                'url'         => null,
                'permissions' => ['users.index'],
            ])
            ->registerItem([
                'id'          => 'cms-core-system-information',
                'priority'    => 5,
                'parent_id'   => 'cms-core-platform-administration',
                'name'        => 'modules.base::system.info.title',
                'icon'        => null,
                'url'         => route('system.info'),
                'permissions' => ['superuser'],
            ]);

        if (function_exists('proc_open')) {
            dashboard_menu()->registerItem([
                'id'          => 'cms-core-system-cache',
                'priority'    => 6,
                'parent_id'   => 'cms-core-platform-administration',
                'name'        => 'modules.base::cache.cache_management',
                'icon'        => null,
                'url'         => route('system.cache'),
                'permissions' => ['superuser'],
            ]);
        }
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
