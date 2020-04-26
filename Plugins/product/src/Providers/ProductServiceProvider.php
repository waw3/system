<?php

namespace Modules\Plugins\Product\Providers;

use Modules\Shortcode\View\View;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Supports\Helper;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Support\ServiceProvider;

use Modules\Plugins\Product\Models\Product;
use Modules\Plugins\Product\Repositories\Caches\ProductCacheDecorator;
use Modules\Plugins\Product\Repositories\Eloquent\ProductRepository;
use Modules\Plugins\Product\Repositories\Interfaces\ProductInterface;

use Modules\Plugins\Product\Models\ProCategory;
use Modules\Plugins\Product\Repositories\Caches\ProCategoryCacheDecorator;
use Modules\Plugins\Product\Repositories\Eloquent\ProCategoryRepository;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;

use Modules\Plugins\Product\Models\ProTag;
use Modules\Plugins\Product\Repositories\Caches\ProTagCacheDecorator;
use Modules\Plugins\Product\Repositories\Eloquent\ProTagRepository;
use Modules\Plugins\Product\Repositories\Interfaces\ProTagInterface;

use Modules\Plugins\Product\Models\Features;
use Modules\Plugins\Product\Repositories\Caches\FeaturesCacheDecorator;
use Modules\Plugins\Product\Repositories\Eloquent\FeaturesRepository;
use Modules\Plugins\Product\Repositories\Interfaces\FeaturesInterface;

use Modules\Plugins\Product\Models\Store;
use Modules\Plugins\Product\Repositories\Caches\StoreCacheDecorator;
use Modules\Plugins\Product\Repositories\Eloquent\StoreRepository;
use Modules\Plugins\Product\Repositories\Interfaces\StoreInterface;

use Modules\Plugins\Product\Models\Cart;
use Modules\Plugins\Product\Repositories\Caches\CartCacheDecorator;
use Modules\Plugins\Product\Repositories\Eloquent\CartRepository;
use Modules\Plugins\Product\Repositories\Interfaces\CartInterface;

use Modules\Plugins\Product\Models\Orderstatus;
use Modules\Plugins\Product\Repositories\Caches\OrderstatusCacheDecorator;
use Modules\Plugins\Product\Repositories\Eloquent\OrderstatusRepository;
use Modules\Plugins\Product\Repositories\Interfaces\OrderstatusInterface;

use Modules\Plugins\Product\Models\Payment;
use Modules\Plugins\Product\Repositories\Caches\PaymentCacheDecorator;
use Modules\Plugins\Product\Repositories\Eloquent\PaymentRepository;
use Modules\Plugins\Product\Repositories\Interfaces\PaymentInterface;

use Modules\Plugins\Product\Models\Shipping;
use Modules\Plugins\Product\Repositories\Caches\ShippingCacheDecorator;
use Modules\Plugins\Product\Repositories\Eloquent\ShippingRepository;
use Modules\Plugins\Product\Repositories\Interfaces\ShippingInterface;

use Event;
use Language;
use SeoHelper;
use SlugHelper;

/**
 * @since 02/07/2016 09:50 AM
 */
class ProductServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(ProductInterface::class, function () {
            return new ProductCacheDecorator(new ProductRepository(new Product));
        });

        $this->app->bind(ProCategoryInterface::class, function () {
            return new ProCategoryCacheDecorator(new ProCategoryRepository(new ProCategory));
        });

        $this->app->bind(ProTagInterface::class, function () {
            return new ProTagCacheDecorator(new ProTagRepository(new ProTag));
        });

        $this->app->bind(FeaturesInterface::class, function () {
            return new FeaturesCacheDecorator(new FeaturesRepository(new Features));
        });

        $this->app->bind(StoreInterface::class, function () {
            return new StoreCacheDecorator(new StoreRepository(new Store));
        });

        $this->app->bind(CartInterface::class, function () {
            return new CartCacheDecorator(new CartRepository(new Cart));
        });

        $this->app->bind(OrderstatusInterface::class, function () {
            return new OrderstatusCacheDecorator(new OrderstatusRepository(new Orderstatus));
        });

        $this->app->bind(PaymentInterface::class, function () {
            return new PaymentCacheDecorator(new PaymentRepository(new Payment));
        });

        $this->app->bind(ShippingInterface::class, function () {
            return new ShippingCacheDecorator(new ShippingRepository(new Shipping));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('modules.plugins.product')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web', 'api'])
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-plugins-product',
                    'priority'    => 3,
                    'parent_id'   => null,
                    'name'        => 'modules.plugins.product::base.menu_name',
                    'icon'        => 'fa fa-edit',
                    'url'         => route('products.index'),
                    'permissions' => ['products.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-product-product',
                    'priority'    => 1,
                    'parent_id'   => 'cms-plugins-product',
                    'name'        => 'modules.plugins.product::products.menu_name',
                    'icon'        => null,
                    'url'         => route('products.index'),
                    'permissions' => ['products.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-product-procategories',
                    'priority'    => 2,
                    'parent_id'   => 'cms-plugins-product',
                    'name'        => 'modules.plugins.product::procategories.menu_name',
                    'icon'        => null,
                    'url'         => route('procategories.index'),
                    'permissions' => ['procategories.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-product-features',
                    'priority'    => 5,
                    'parent_id'   => 'cms-plugins-product',
                    'name'        => 'modules.plugins.product::features.name',
                    'icon'        => null,
                    'url'         => route('features.index'),
                    'permissions' => ['features.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-product-store',
                    'priority'    => 6,
                    'parent_id'   => 'cms-plugins-product',
                    'name'        => 'modules.plugins.product::store.name',
                    'icon'        => null,
                    'url'         => route('store.index'),
                    'permissions' => ['store.index'],
                ])

                ->registerItem([
                    'id'          => 'cms-plugins-cart',
                    'priority'    => 4,
                    'parent_id'   => null,
                    'name'        => 'modules.plugins.product::cart.name',
                    'icon'        => 'fa fa-edit',
                    'url'         => route('cart.index'),
                    'permissions' => ['cart.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-product-cart',
                    'priority'    => 1,
                    'parent_id'   => 'cms-plugins-cart',
                    'name'        => 'modules.plugins.product::cart.namelist',
                    'icon'        => null,
                    'url'         => route('cart.index'),
                    'permissions' => ['cart.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-orderstatus-cart',
                    'priority'    => 2,
                    'parent_id'   => 'cms-plugins-cart',
                    'name'        => 'modules.plugins.product::orderstatus.name',
                    'icon'        => null,
                    'url'         => route('orderstatus.index'),
                    'permissions' => ['orderstatus.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-payment-cart',
                    'priority'    => 3,
                    'parent_id'   => 'cms-plugins-cart',
                    'name'        => 'modules.plugins.product::payment.name',
                    'icon'        => null,
                    'url'         => route('payment.index'),
                    'permissions' => ['payment.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-shipping-cart',
                    'priority'    => 4,
                    'parent_id'   => 'cms-plugins-cart',
                    'name'        => 'modules.plugins.product::shipping.name',
                    'icon'        => null,
                    'url'         => route('shipping.index'),
                    'permissions' => ['shipping.index'],
                ]);
        });

        $this->app->booted(function () {
            $models = [Product::class, ProCategory::class,ProTag::class,Features::class];

            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule($models);
                SlugHelper::registerModule($models);
            }
            SlugHelper::registerModule($models);
            SlugHelper::setPrefix(ProTag::class, 'tag');
            SeoHelper::registerModule($models);

        });




        if (function_exists('shortcode')) {
            view()->composer([
                'modules.plugins.product::themes.product',
                'modules.plugins.product::themes.procategory',

                'modules.plugins.product::themes.protag',
            ], function (View $view) {
                $view->withShortcodes();
            });
        }
    }
}
