<?php

namespace Modules\Plugins\Gallery\Providers;

use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Supports\Helper;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Modules\Plugins\Gallery\Facades\GalleryFacade;
use Modules\Plugins\Gallery\Models\Gallery;
use Modules\Plugins\Gallery\Models\GalleryMeta;
use Modules\Plugins\Gallery\Repositories\Caches\GalleryMetaCacheDecorator;
use Modules\Plugins\Gallery\Repositories\Eloquent\GalleryMetaRepository;
use Modules\Plugins\Gallery\Repositories\Interfaces\GalleryMetaInterface;
use Event;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Modules\Plugins\Gallery\Repositories\Caches\GalleryCacheDecorator;
use Modules\Plugins\Gallery\Repositories\Eloquent\GalleryRepository;
use Modules\Plugins\Gallery\Repositories\Interfaces\GalleryInterface;
use Language;
use SeoHelper;
use SlugHelper;

class GalleryServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
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

        Helper::autoload(__DIR__ . '/../../helpers');

        AliasLoader::getInstance()->alias('Gallery', GalleryFacade::class);
    }

    public function boot()
    {
        $this->setNamespace('modules.plugins.gallery')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-gallery', // key of menu, it should unique
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'modules.plugins.gallery::gallery.menu_name', // menu name, if you don't need translation, you can use the name in plain text
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
}
