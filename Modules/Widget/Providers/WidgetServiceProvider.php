<?php namespace Modules\Widget\Providers;

use Event, File, WidgetGroup;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Modules\Base\Supports\Helper;
use Modules\Support\Traits\ModuleServiceProvider;
use Modules\Widget\Factories\WidgetFactory;
use Modules\Widget\Misc\LaravelApplicationWrapper;
use Modules\Widget\Models\Widget;
use Modules\Widget\Repositories\Caches\WidgetCacheDecorator;
use Modules\Widget\Repositories\Eloquent\WidgetRepository;
use Modules\Widget\Repositories\Interfaces\WidgetInterface;
use Modules\Widget\Services\WidgetGroupCollection;
use Modules\Widget\Widgets\Text;


/**
 * WidgetServiceProvider class.
 *
 * @extends ServiceProvider
 */
class WidgetServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Widget';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'widget';

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
       //'backend.includes.sidebar' => \Modules\Widget\Http\Composers\Backend\Composer::class
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
        //\Modules\Widget\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        //\Modules\Widget\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
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

        $this->app->booted(function () {

            WidgetGroup::setGroup([
                'id'          => 'primary_sidebar',
                'name'        => 'Primary sidebar',
                'description' => 'This is primary sidebar section',
            ]);

            register_widget(Text::class);

            $widget_path = theme_path(setting('theme') . '/widgets');
            $widgets = scan_folder($widget_path);
            if (!empty($widgets) && is_array($widgets)) {
                foreach ($widgets as $widget) {
                    $registration = $widget_path . '/' . $widget . '/registration.php';
                    if (File::exists($registration)) {
                        File::requireOnce($registration);
                    }
                }
            }
        });

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-core-widget',
                    'priority'    => 3,
                    'parent_id'   => 'cms-core-appearance',
                    'name'        => 'modules.base::layouts.widgets',
                    'icon'        => null,
                    'url'         => route('widgets.index'),
                    'permissions' => ['widgets.index'],
                ]);

            if (function_exists('admin_bar')) {
                admin_bar()->registerLink('Widget', route('widgets.index'), 'appearance');
            }
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
        $this->app->bind(WidgetInterface::class, function () {
            return new WidgetCacheDecorator(new WidgetRepository(new Widget));
        });

        $this->app->bind('modules.widget', function () {
            return new WidgetFactory(new LaravelApplicationWrapper);
        });

        $this->app->singleton('modules.widget-group-collection', function () {
            return new WidgetGroupCollection(new LaravelApplicationWrapper);
        });
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
