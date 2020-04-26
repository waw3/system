<?php namespace Modules\PluginManagement\Providers;

use Event, Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Composer\Autoload\ClassLoader;
use Psr\SimpleCache\InvalidArgumentException;
use Modules\Support\Traits\ModuleServiceProvider;

/**
 * PluginManagementServiceProvider class.
 *
 * @extends ServiceProvider
 */
class PluginManagementServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'PluginManagement';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'pluginmanagement';

    /**
     * The command mappings for the application.
     *
     * @var array
     */
    protected $commands = [
        \Modules\PluginManagement\Console\Commands\PluginActivateCommand::class => 'command.cms:plugin:activate',
        \Modules\PluginManagement\Console\Commands\PluginDeactivateCommand::class => 'command.cms:plugin:deactivate',
        \Modules\PluginManagement\Console\Commands\PluginRemoveCommand::class => 'command.cms:plugin:remove'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        \Modules\PluginManagement\Console\Commands\PluginAssetsPublishCommand::class => 'command.cms:plugin:assets:publish'
    ];


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootModule();




        $plugins = get_active_plugins();



        if (!empty($plugins) && is_array($plugins)) {

            $loader = new ClassLoader;
            $providers = [];
            $namespaces = [];


            if (cache()->has('plugin_namespaces') && cache()->has('plugin_providers')) {

                $providers = cache('plugin_providers');

                if (!is_array($providers) || empty($providers)) {
                    $providers = [];
                }

                $namespaces = cache('plugin_namespaces');

                if (!is_array($namespaces) || empty($namespaces)) {
                    $namespaces = [];
                }
            }



            if (empty($namespaces) || empty($providers)) {

                foreach ($plugins as $plugin) {

                    if (empty($plugin)) {
                        continue;
                    }

                    $pluginPath = plugin_path($plugin);

                    if (!File::exists($pluginPath . '/plugin.json')) {
                        continue;
                    }

                    $content = get_file_data($pluginPath . '/plugin.json');
                    if (!empty($content)) {
                        if (Arr::has($content, 'namespace') && !class_exists($content['provider'])) {
                            $namespaces[$plugin] = $content['namespace'];
                        }

                        $providers[] = $content['provider'];
                    }
                }

                cache()->forever('plugin_namespaces', $namespaces);
                cache()->forever('plugin_providers', $providers);
            }

            foreach ($namespaces as $key => $namespace) {
                $loader->setPsr4($namespace, plugin_path($key . '/src'));
            }

            $loader->register();


            foreach ($providers as $provider) {
                if (!class_exists($provider)) {
                    continue;
                }

                $this->app->register($provider);
            }
        }

//         $this->app->register(HookServiceProvider::class);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-core-plugins',
                    'priority'    => 997,
                    'parent_id'   => null,
                    'name'        => 'modules.base::layouts.plugins',
                    'icon'        => 'fa fa-plug',
                    'url'         => route('plugins.index'),
                    'permissions' => ['plugins.index'],
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
