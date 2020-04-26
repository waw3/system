<?php namespace Modules\Theme\Providers;

use Event, File;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Theme\Commands\ThemeAssetsPublishCommand;
use Modules\Theme\Commands\ThemeAssetsRemoveCommand;
use Modules\Support\Traits\ModuleServiceProvider;
use Modules\Theme\Commands\ThemeActivateCommand;
use Modules\Theme\Commands\ThemeRemoveCommand;
use Modules\Theme\Contracts\Theme as ThemeContract;
use Modules\Theme\Facades\ThemeFacade;
use Modules\Theme\Http\Middleware\AdminBarMiddleware;
use Modules\Theme\Services\Theme;
use Modules\Base\Supports\Helper;

/**
 * ThemeServiceProvider class.
 *
 * @extends ServiceProvider
 */
class ThemeServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Theme';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'theme';

    /**
     * The command mappings for the application.
     *
     * @var array
     */
    protected $commands = [
        \Modules\Theme\Console\Commands\ThemeActivateCommand::class => 'command.cms:theme:activate',
        \Modules\Theme\Console\Commands\ThemeRemoveCommand::class => 'command.cms:theme:remove',
        \Modules\Theme\Console\Commands\ThemeAssetsPublishCommand::class => 'command.cms:theme:assets:publish',
        \Modules\Theme\Console\Commands\ThemeAssetsRemoveCommand::class => 'command.cms:theme:assets:remove'
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
                    'id'          => 'cms-core-appearance',
                    'priority'    => 996,
                    'parent_id'   => null,
                    'name'        => 'modules.base::layouts.appearance',
                    'icon'        => 'fa fa-paint-brush',
                    'url'         => '#',
                    'permissions' => [],
                ])
                ->registerItem([
                    'id'          => 'cms-core-theme',
                    'priority'    => 1,
                    'parent_id'   => 'cms-core-appearance',
                    'name'        => 'modules.theme::theme.name',
                    'icon'        => null,
                    'url'         => route('theme.index'),
                    'permissions' => ['theme.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-core-theme-option',
                    'priority'    => 4,
                    'parent_id'   => 'cms-core-appearance',
                    'name'        => 'modules.theme::theme.theme_options',
                    'icon'        => null,
                    'url'         => route('theme.options'),
                    'permissions' => ['theme.options'],
                ])
                ->registerItem([
                    'id'          => 'cms-core-appearance-custom-css',
                    'priority'    => 5,
                    'parent_id'   => 'cms-core-appearance',
                    'name'        => 'modules.theme::theme.custom_css',
                    'icon'        => null,
                    'url'         => route('theme.custom-css'),
                    'permissions' => ['theme.custom-css'],
                ]);

            admin_bar()->registerLink('Theme', route('theme.index'), 'appearance');
        });

        if (Helper::isConnectedDatabase()) {
            $this->app->booted(function () {
                $file = mconfig('theme.config.themeDir') . '/' . setting('theme') . '/css/style.integration.css';
                if (File::exists(public_path($file))) {
                    ThemeFacade::getFacadeRoot()
                        ->asset()
                        ->container('after_header')
                        ->add('theme-style-integration-css', $file);
                }

                if (!setting('theme')) {
                    setting()->set('theme', Arr::first(scan_folder(theme_path())));
                }
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

        /**
         * @var Router $router
         */
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', AdminBarMiddleware::class);

    }


    /**
     * registerBinders function.
     *
     * @access private
     * @return void
     */
    private function registerBinders()
    {
        $this->app->bind(ThemeContract::class, Theme::class);
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
