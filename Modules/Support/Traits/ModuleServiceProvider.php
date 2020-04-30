<?php namespace Modules\Support\Traits;

use File, Event, Gate;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Module as ModuleGeneratorModule;

/**
 * Provider trait.
 */
trait ModuleServiceProvider
{

	/**
	 * module
	 *
	 * @var mixed
	 * @access protected
	 */
	protected $module;

    /**
     * bootModule function.
     *
     * @access protected
     * @return void
     */
    protected function bootModule()
    {

        $moduleName = explode('\\', get_called_class())[1];
	    $this->module = Module::find($moduleName);


        $this->registerMiddlewares($moduleName);
        $this->registerPolicies();
        $this->registerCommands();
        $this->registerEvents();
        $this->registerAliases();
        $this->registerComposerViews();

    }


    /**
     * registerModule function.
     *
     * @access protected
     * @return void
     */
    protected function registerModule()
    {
        $moduleName = explode('\\', get_called_class())[1];

	    $this->module = Module::find($moduleName);

        $this->includeHelperFunctions();

	    if(property_exists($this, 'providers')) $this->registerProviders();
	    if(method_exists($this,'registerBinders')) $this->registerBinders();
    }

    /**
     * includeHelperFunctions function.
     *
     * @access public
     * @return void
     */
    public function includeHelperFunctions()
    {
        $dir = $this->module->getPath() . '/Helpers/Functions';

        if (is_dir($dir))
            foreach(File::glob($dir . '/{**/*,*}.php', GLOB_BRACE) as $filename) include_once($filename);
    }


    /**
     * Register the filters.
     *
     * @param  Router $router
     * @return void
     */
/*
    public function registerMiddleware(Router $router)
    {
        foreach ($this->middleware as $module => $middlewares) {
            foreach ($middlewares as $name => $middleware) {
                $class = "Modules\\{$module}\\Http\\Middleware\\{$middleware}";

                $router->aliasMiddleware($name, $class);
            }
        }
    }
*/

	/**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerMiddlewares($module)
    {
	    $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');

        if(property_exists($this, 'middleware')){
            // register global middleware.
            foreach ($this->middleware as $middleware) {
    	        $kernel->pushMiddleware($middleware);
            }
        }

        if(property_exists($this, 'routeMiddleware')){
            // register route middleware.
            foreach ($this->routeMiddleware as $key => $middleware) {
                app('router')->aliasMiddleware($key, $middleware);
            }
        }

        if(property_exists($this, 'middlewareGroups')){
            // register middleware group.
            foreach ($this->middlewareGroups as $key => $middleware) {
                app('router')->pushMiddlewareToGroup($key, $middleware);
            }
        }

    }

    /**
     * registerComposerViews function.
     * view()->composer('*', CLASS\FILE::class);
     * @access protected
     * @return void
     */
    protected function registerComposerViews()
    {
        if(property_exists($this, 'composerViews')){
            foreach ($this->composerViews as $view => $class) {
                view()->composer($view, $class);
            }
        }
    }

    /**
     * Register multiple service providers.
     *
     * @param  array  $providers3
     */
    protected function registerProviders()
    {
        if(property_exists($this, 'providers')){
            foreach ($this->providers as $provider) {
                $this->registerProvider($provider);
            }
        }
    }

    /**
     * Register a service provider.
     *
     * @param  \Illuminate\Support\ServiceProvider|string  $provider
     * @param  array                                       $options
     * @param  bool                                        $force
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    protected function registerProvider($provider, array $options = [], $force = false)
    {
        return $this->app->register($provider, $options, $force);
    }

        /**
     * Register a console service provider.
     *
     * @param  \Illuminate\Support\ServiceProvider|string  $provider
     * @param  array                                       $options
     * @param  bool                                        $force
     *
     * @return \Illuminate\Support\ServiceProvider|null
     */
    protected function registerConsoleServiceProvider($provider, array $options = [], $force = false)
    {
        if ($this->app->runningInConsole())
            return $this->registerProvider($provider, $options, $force);

        return null;
    }

    /**
     * registerCommands function. Register the console commands
     *
     * @access private
     * @return void
     */
    private function registerCommands()
    {
        if(property_exists($this, 'commands')){

        // Register artisan commands
        foreach ($this->commands as $key => $value) {
            $this->singleton($value, $key);
        }

        $this->commands(array_values($this->commands));

        if ($this->app->runningInConsole() && property_exists($this, 'commandsInConsoleOnly'))
            $this->registerCommandsInConsoleOnly();

        }
    }

    /**
     * registerCommandsInConsoleOnly function. Register the console commands Running in cli
     *
     * @access private
     * @return void
     */
    private function registerCommandsInConsoleOnly()
    {
        if(property_exists($this, 'commandsInConsoleOnly')){
            foreach ($this->commandsInConsoleOnly as $key => $value) {
                $this->singleton($value, $key);
            }

            $this->commands(array_values($this->commandsInConsoleOnly));
        }
    }

    /**
     * registerAliases function.
     *
     * @access protected
     * @return void
     */
    protected function registerAliases()
    {
        if(property_exists($this, 'aliases')){
            foreach ($this->aliases as $class => $alias) {
                AliasLoader::getInstance()->alias($class, $alias);
            }
        }
    }


    /**
     * registerPolicies function.
     *
     * @access public
     * @return void
     */
    public function registerPolicies()
    {
        if(property_exists($this, 'policies')){
            foreach ($this->policies as $key => $value) {
                Gate::policy($key, $value);
            }
        }
    }

    /**
     * registerModuleConfig function.
     *
     * @access protected
     * @param ModuleGeneratorModule $module
     * @return void
     */
    protected function registerModuleConfig(ModuleGeneratorModule $module)
    {
	    //$cFiles = File::glob($this->getConfigFolder() . '/{**/*,*}.php', GLOB_BRACE);realpath(base_path('Modules/Core/Config'))
        if(is_dir($module->getPath() . DS . 'Config'))
        {
            foreach (File::allFiles($module->getPath() . DS . 'Config') as $file){
                $this->mergeConfigFrom($file, "modules." . $module->getLowerName() . "." . strtolower(File::name($file)));
    		}
        }
    }

    /**
     * registerModuleMigration function.
     *
     * @access private
     * @param ModuleGeneratorModule $module
     * @return void
     */
    private function registerModuleMigration(ModuleGeneratorModule $module)
    {
        $sourcePath = $module->getPath() . '/Database/Migrations';

        if(is_dir($sourcePath))
            $this->loadMigrationsFrom($sourcePath);
    }

    /**
     * registerModuleViewNamespace function.
     *
     * @access private
     * @param ModuleGeneratorModule $module
     * @return void
     */
    private function registerModuleViewNamespace(ModuleGeneratorModule $module)
    {

        $viewPath = resource_path('views/modules/' . $module->getLowerName());
        $sourcePath = modules_path($module->getName() . '/Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $module->getLowerName() . '-module-views']);


        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths($module), [$sourcePath]), "modules." . $module->getLowerName());

    }

    /**
     * @param null $path
     * @return $this
     */
    public function registerModulePublicAssets(ModuleGeneratorModule $module): self
    {
        if ($this->app->runningInConsole()) {

            $sourcePath = $module->getPath() . '/Resources/public';

            if(is_dir($sourcePath))
                $this->publishes([$sourcePath => public_path('assets/modules/' . $module->getLowerName())], $module->getLowerName() . '-public');
        }

        return $this;
    }

    /**
     * getPublishableViewPaths function.
     *
     * @access private
     * @return void
     */
    private function getPublishableViewPaths(ModuleGeneratorModule $module): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $module->getLowerName())) {
                $paths[] = $path . '/modules/' . $module->getLowerName();
            }
        }
        return $paths;
    }



    /**
     * @return string
     */
    protected function getDotedNamespace(): string
    {
        return str_replace('/', '.', $this->namespace);
    }

    /**
     * @return string
     */
    protected function getFolderNamespace(): string
    {
        return str_replace('.', '/', $this->namespace);
    }


    /**
     * registerModuleLanguageNamespace function.
     *
     * @access private
     * @param ModuleGeneratorModule $module
     * @return void
     */
    private function registerModuleLanguageNamespace(ModuleGeneratorModule $module)
    {
        $langPath = resource_path('lang/modules/' . $module->getLowerName());

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $module->getLowerName());
        } else {
            $this->loadTranslationsFrom(module_path($module->getName(), 'Resources/lang'), "modules." . $module->getLowerName());
        }
    }



    /**
     * registerModuleFactories function.
     *
     * @access private
     * @param ModuleGeneratorModule $module
     * @return void
     */
    private function registerModuleFactories(ModuleGeneratorModule $module)
    {
        $dir = $module->getPath() . DS . 'Database' . DS . 'Factories';

        if (is_dir($dir)) {
            app(EloquentFactory::class)->load($dir);
        }
    }



	 /**
     * Register a binding with the container.
     *
     * @param  string|array          $abstract
     * @param  \Closure|string|null  $concrete
     * @param  bool                  $shared
     */
    public function bind($abstract, $concrete = null, $shared = false)
    {
        $this->app->bind($abstract, $concrete, $shared);
    }

    /**
     * Register a shared binding in the container.
     *
     * @param  string|array          $abstract
     * @param  \Closure|string|null  $concrete
     */
    protected function singleton($abstract, $concrete = null)
    {
        $this->app->singleton($abstract, $concrete);
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }

    /**
     * registerEvents function. Register the application's event listeners.
     *
     * @access public
     * @return void
     */
    public function registerEvents()
    {
        if(property_exists($this, 'listen')){
    		foreach ($this->listens() as $event => $listeners) {
                foreach ($listeners as $listener) {
                    Event::listen($event, $listener);
                }
            }
        }
        if(property_exists($this, 'subscribe')){
            foreach ($this->subscribe as $subscriber) {
                Event::subscribe($subscriber);
            }
        }
    }

    /**
     * __isset function.
     *
     * @access public
     * @param mixed $property
     * @return void
     */
    public function __isset($property){
        return isset($this->$property);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
    /**
     * Get the view factory instance.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    protected function view()
    {
        return $this->app->make(IlluminateViewFactory::class);
    }
    /**
     * Register a view composer event.
     *
     * @param  array|string     $views
     * @param  \Closure|string  $callback
     *
     * @return array
     */
    public function composer($views, $callback)
    {
        return $this->view()->composer($views, $callback);
    }

}
