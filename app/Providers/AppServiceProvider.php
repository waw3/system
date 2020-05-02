<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema, Carbon;
use Illuminate\Routing\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Sets third party service providers that are only needed on local/testing environments
        if ($this->app->environment() !== 'production') {
            /**
             * Loader for registering facades.
             */
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();

            // Load third party local aliases
            $loader->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
        }



        $this->registerBinders();



        foreach(\File::glob(__DIR__ . '/../Helpers/Functions/{**/*,*}.php', GLOB_BRACE) as $filename) include $filename;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        /*
         * Application locale defaults for various components
         *
         * These will be overridden by LocaleMiddleware if the session local is set
         */

        // setLocale for php. Enables ->formatLocalized() with localized values for dates
        setlocale(LC_TIME, config('app.locale_php'));

        // setLocale to use Carbon source locales. Enables diffForHumans() localized
        Carbon::setLocale(config('app.locale'));

        // Force SSL in production
        /*if ($this->app->environment() === 'production') {
            URL::forceScheme('https');
        }*/

        // Set the default template for Pagination to use the included Bootstrap 4 template
        \Illuminate\Pagination\AbstractPaginator::defaultView('pagination::bootstrap-4');
        \Illuminate\Pagination\AbstractPaginator::defaultSimpleView('pagination::simple-bootstrap-4');

        Schema::defaultStringLength(191);




/*
        $registrar = new \App\Overrides\Illuminate\Routing\RouteRegistrar($this->app['router']);
        $this->app->bind('Illuminate\Routing\RouteRegistrar', function () use ($registrar) {
            return $registrar;
        });
*/


        if (! Route::hasMacro('permission')) {
            Route::macro('permission', function ($permission) {
                $this->action['permission'] = isset($this->action['permission']) ? $this->action['permission'].$permission : $permission;

                return $this;
            });
        }


//         $registrar = new \App\Overrides\Illuminate\Routing\ResourceRegistrar($this->app['router']);
        // Route::resource('demo', 'DemoController', ['where' => ['demo' => '[0-9]+']]);
/*
        $this->app->bind('Illuminate\Routing\ResourceRegistrar', function () use ($registrar) {
            return $registrar;
        });
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

        $this->app->bind('placeholder', \App\Services\PlaceHolder\Holder::class);

    }
}
