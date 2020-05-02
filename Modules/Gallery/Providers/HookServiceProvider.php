<?php

namespace Modules\Gallery\Providers;

use Assets;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    /**
     * @throws \Throwable
     */
    public function boot()
    {
        add_action('meta_boxes', [$this, 'addGalleryBox'], 13, 2);

        if (function_exists('shortcode')) {
            add_shortcode('gallery', trans('modules.gallery::gallery.gallery_images'), trans('modules.gallery::gallery.add_gallery_short_code'), [$this, 'render']);
            shortcode()->setAdminConfig('gallery', view('modules.gallery::partials.short-code-admin-config')->render());
        }
    }

    /**
     * @param string $context
     * @param $object
     */
    public function addGalleryBox($context, $object)
    {
        if ($object && in_array(get_class($object), mconfig('gallery.config.supported', [])) && $context == 'advanced') {
            Assets::addStylesDirectly(['vendor/core/plugins/gallery/css/admin-gallery.css'])->addScripts(['sortable']);
            add_meta_box('gallery_wrap', trans('modules.gallery::gallery.gallery_box'), [$this, 'galleryMetaField'], get_class($object), $context, 'default');
        }
    }

    /**
     * @throws \Throwable
     * @return string
     */
    public function galleryMetaField()
    {
        $value = null;
        $args = func_get_args();
        if ($args[0] && $args[0]->id) {
            $value = gallery_meta_data($args[0]);
        }

        return view('modules.gallery::gallery-box', compact('value'))->render();
    }

    /**
     * @param $shortcode
     * @return string
     */
    public function render($shortcode)
    {
        return render_galleries($shortcode->limit ? $shortcode->limit : 6);
    }
}
