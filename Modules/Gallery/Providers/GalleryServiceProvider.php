<?php namespace Modules\Gallery\Providers;

use Illuminate\Support\ServiceProvider;
use Language, SeoHelper, SlugHelper, Event;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Support\Traits\ModuleServiceProvider;
use Modules\Gallery\Facades\GalleryFacade;
use Modules\Gallery\Models\Gallery;
use Modules\Gallery\Models\GalleryMeta;
use Modules\Gallery\Repositories\Caches\GalleryMetaCacheDecorator;
use Modules\Gallery\Repositories\Eloquent\GalleryMetaRepository;
use Modules\Gallery\Repositories\Interfaces\GalleryMetaInterface;
use Modules\Gallery\Repositories\Caches\GalleryCacheDecorator;
use Modules\Gallery\Repositories\Eloquent\GalleryRepository;
use Modules\Gallery\Repositories\Interfaces\GalleryInterface;


/**
 * GalleryServiceProvider class.
 *
 * @extends ServiceProvider
 */
class GalleryServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Gallery';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'gallery';

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
        //
    ];

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Modules\Theme\Events\RenderingSiteMapEvent::class => [
            \Modules\Gallery\Listeners\RenderingSiteMapListener::class,
        ],
        \Modules\Base\Events\UpdatedContentEvent::class   => [
            \Modules\Gallery\Listeners\UpdatedContentListener::class,
        ],
        \Modules\Base\Events\CreatedContentEvent::class   => [
            \Modules\Gallery\Listeners\CreatedContentListener::class,
        ],
        \Modules\Base\Events\DeletedContentEvent::class   => [
            \Modules\Gallery\Listeners\DeletedContentListener::class,
        ],
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
                'id'          => 'cms-plugins-gallery', // key of menu, it should unique
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'modules.gallery::gallery.menu_name', // menu name, if you don't need translation, you can use the name in plain text
                'icon'        => 'fa fa-camera',
                'url'         => route('galleries.index'),
                'permissions' => ['galleries.index'], // permission should same with route name, you can see that flag in Plugin.php
            ]);
        });

        $this->app->booted(function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule([Gallery::class]);
            }

            SlugHelper::registerModule(Gallery::class);
            SlugHelper::setPrefix(Gallery::class, 'gallery');
            SeoHelper::registerModule([Gallery::class]);
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
        $this->app->bind(GalleryInterface::class, function () {
            return new GalleryCacheDecorator(
                new GalleryRepository(new Gallery)
            );
        });

        $this->app->bind(GalleryMetaInterface::class, function () {
            return new GalleryMetaCacheDecorator(
                new GalleryMetaRepository(new GalleryMeta)
            );
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
