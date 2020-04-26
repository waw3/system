<?php namespace Modules\Page\Providers;

use Modules\Base\Supports\Helper;
use Modules\Page\Models\Page;
use Modules\Page\Repositories\Caches\PageCacheDecorator;
use Modules\Page\Repositories\Eloquent\PageRepository;
use Modules\Page\Repositories\Interfaces\PageInterface;
use Modules\Shortcode\View\View;
use Event;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Modules\Support\Traits\ModuleServiceProvider;

/**
 * PageServiceProvider class.
 *
 * @extends ServiceProvider
 */
class PageServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Page';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'page';

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
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Modules\Theme\Events\RenderingSiteMapEvent::class => [
            \Modules\Page\Listeners\RenderingSiteMapListener::class,
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
        //\Modules\Page\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        //\Modules\Page\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
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
            dashboard_menu()->registerItem([
                'id'          => 'cms-core-page',
                'priority'    => 2,
                'parent_id'   => null,
                'name'        => 'modules.page::pages.menu_name',
                'icon'        => 'fa fa-book',
                'url'         => route('pages.index'),
                'permissions' => ['pages.index'],
            ]);

            if (function_exists('admin_bar')) {
                admin_bar()->registerLink('Page', route('pages.index'), 'add-new');
            }
        });

        if (function_exists('shortcode')) {
            view()->composer(['modules.page::themes.page'], function (View $view) {
                $view->withShortcodes();
            });
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
        $this->app->bind(PageInterface::class, function () {
            return new PageCacheDecorator(new PageRepository(new Page));
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
