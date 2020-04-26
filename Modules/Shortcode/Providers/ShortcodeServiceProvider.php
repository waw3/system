<?php namespace Modules\Shortcode\Providers;


use Illuminate\Support\ServiceProvider;
use Modules\Shortcode\Compilers\ShortcodeCompiler;
use Modules\Shortcode\Services\Shortcode;
use Modules\Shortcode\View\Factory;
use Modules\Support\Traits\ModuleServiceProvider;

/**
 * ShortcodeServiceProvider class.
 *
 * @extends ServiceProvider
 */
class ShortcodeServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Shortcode';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'shortcode';


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
        $this->app->singleton('shortcode.compiler', ShortcodeCompiler::class);

        $this->app->singleton('shortcode', function ($app) {
            return new Shortcode($app['shortcode.compiler']);
        });

        $this->app->singleton('view', function ($app) {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $app['view.engine.resolver'];
            $finder = $app['view.finder'];
            $env = new Factory($resolver, $finder, $app['events'], $app['shortcode.compiler']);
            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $env->setContainer($app);
            $env->share('app', $app);
            return $env;
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['shortcode.compiler', 'shortcode'];
    }
}
