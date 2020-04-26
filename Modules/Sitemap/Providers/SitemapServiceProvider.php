<?php namespace Modules\Sitemap\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Support\Traits\ModuleServiceProvider;
use Modules\Sitemap\Services\Sitemap;

/**
 * SitemapServiceProvider class.
 *
 * @extends ServiceProvider
 */
class SitemapServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Sitemap';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'sitemap';

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
        $this->app->bind('sitemap', function ($app) {
            $config = mconfig('sitemap.config');

            return new Sitemap(
                $config,
                $app['Illuminate\Cache\Repository'],
                $app['Illuminate\Contracts\Routing\ResponseFactory'],
                $app['view']
            );
        });

        $this->app->alias('sitemap', Sitemap::class);
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sitemap', Sitemap::class];
    }
}
