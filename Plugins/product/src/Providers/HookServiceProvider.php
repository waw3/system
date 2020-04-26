<?php

namespace Modules\Plugins\Product\Providers;

use Assets, Auth, Theme, Event, Eloquent, Html, Menu, SeoHelper, stdClass, Throwable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Product\Models\ProCategory;
use Modules\Plugins\Product\Models\Product;
use Modules\Plugins\Product\Models\ProTag;
use Modules\Dashboard\Supports\DashboardWidgetInstance;
use Modules\Base\Supports\Helper;
use Modules\Page\Models\Page;
use Modules\Page\Repositories\Interfaces\PageInterface;
use Modules\SeoHelper\Services\SeoOpenGraph;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Modules\Plugins\Product\Repositories\Interfaces\ProTagInterface;
use Modules\Plugins\Product\Repositories\Interfaces\ProductInterface;

class HookServiceProvider extends ServiceProvider
{
    /**
     * @throws Throwable
     */
    public function boot()
    {
        if (defined('MENU_ACTION_SIDEBAR_OPTIONS')) {
            add_action(MENU_ACTION_SIDEBAR_OPTIONS, [$this, 'registerMenuOptions'], 2);
        }
        add_filter('admin_dashboard_list', [$this, 'registerDashboardWidgets'], 21, 2);
        add_filter(BASE_FILTER_PUBLIC_SINGLE_DATA, [$this, 'handleSingleView'], 2, 1);
        if (defined('PAGE_MODULE_SCREEN_NAME')) {
            add_filter(PAGE_FILTER_FRONT_PAGE_CONTENT, [$this, 'renderProductPage'], 2, 2);
            add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSettings'], 47, 1);
            add_filter(PAGE_FILTER_PAGE_NAME_IN_ADMIN_LIST, [$this, 'addAdditionNameToPageName'], 147, 2);
        }

        if (function_exists('admin_bar')) {
            Event::listen(RouteMatched::class, function () {
                admin_bar()->registerLink('Product', route('products.create'), 'add-new');
            });
        }

        if (function_exists('add_shortcode')) {
            add_shortcode('ecomerce-products', __('Ecomerce products'), __('Add ecomerce products'), [$this, 'renderEcomerceProducts']);
            shortcode()->setAdminConfig('ecomerce-products',
                view('modules.plugins.product::partials.products-short-code-admin-config')->render());
        }
    }

    /**
     * Register sidebar options in menu
     * @throws Throwable
     */
    public function registerMenuOptions()
    {


        if (Auth::user()->hasPermission('procategories.index')) {
            $procategories = Menu::generateSelect([
                'model'   => $this->app->make(ProCategoryInterface::class)->getModel(),
                'type'    => ProCategory::class,
                'theme'   => false,
                'options' => [
                    'class' => 'list-item',
                ],
            ]);
            echo view('modules.plugins.product::procategories.menu-options', compact('procategories'));
        }

        if (Auth::user()->hasPermission('protags.index')) {
            $protags = Menu::generateSelect([
                'model'   => $this->app->make(ProTagInterface::class)->getModel(),
                'type'    => ProTag::class,
                'theme'   => false,
                'options' => [
                    'class' => 'list-item',
                ],
            ]);
            echo view('modules.plugins.product::protags.partials.menu-options', compact('protags'));
        }
    }

    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function registerDashboardWidgets($widgets, $widgetSettings)
    {
        if (!Auth::user()->hasPermission('products.index')) {
            return $widgets;
        }

        Assets::addScriptsDirectly(['/vendor/core/plugins/product/js/product.js']);

        return (new DashboardWidgetInstance)
            ->setPermission('products.index')
            ->setKey('widget_products_recent')
            ->setTitle(trans('modules.plugins.product::products.widget_products_recent'))
            ->setIcon('fas fa-edit')
            ->setColor('#f3c200')
            ->setRoute(route('products.widget.recent-products'))
            ->setBodyClass('scroll-table')
            ->setColumn('col-md-6 col-sm-6')
            ->init($widgets, $widgetSettings);
    }

    /**
     * @param Eloquent $slug
     * @return array|Eloquent
     *
     * @throws FileNotFoundException
     * @throws BindingResolutionException
     */
    public function handleSingleView($slug)
    {
        if ($slug instanceof Eloquent) {
            $data = [];
            $condition = [
                'id'     => $slug->reference_id,
                'status' => BaseStatusEnum::PUBLISHED,
            ];

            if (Auth::check() && request('preview')) {
                Arr::forget($condition, 'status');
            }

            switch ($slug->reference_type) {
                case Product::class:
                    $product = $this->app->make(ProductInterface::class)
                        ->getFirstBy($condition, ['*'],
                            ['procategories', 'slugable', 'procategories.slugable']);

                    if (!empty($product)) {
                        Helper::handleViewCount($product, 'viewed_product');

                        SeoHelper::setTitle($product->name)->setDescription($product->description);

                        $meta = new SeoOpenGraph;
                        if ($product->imagedl) {
                            $meta->setImage(get_image_url($product->imagedl));
                        }
                        $meta->setDescription($product->description);
                        $meta->setUrl($product->url);
                        $meta->setTitle($product->name);
                        $meta->setType('article');

                        SeoHelper::setSeoOpenGraph($meta);

                        if (function_exists('admin_bar')) {
                            admin_bar()->registerLink(trans('modules.plugins.product::products.edit_this_product'),
                                route('products.edit', $product->id));
                        }

                        Theme::breadcrumb()->add(__('Home'), url('/'))->add($product->name, $product->url);

                        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, PRODUCT_MODULE_SCREEN_NAME, $product);

                        $data = [
                            'view'         => 'product',
                            'default_view' => 'modules.plugins.product::themes.product',
                            'data'         => compact('product'),
                            'slug'         => $product->slug,
                        ];
                    }
                    break;
                case ProCategory::class:
                    $procategory = $this->app->make(ProCategoryInterface::class)
                        ->getFirstBy($condition, ['*'], ['slugable']);
                    if (!empty($procategory)) {
                        SeoHelper::setTitle($procategory->name)->setDescription($procategory->description);

                        $meta = new SeoOpenGraph;
                        if ($procategory->image) {
                            $meta->setImage(get_image_url($procategory->image));
                        }
                        $meta->setDescription($procategory->description);
                        $meta->setUrl($procategory->url);
                        $meta->setTitle($procategory->name);
                        $meta->setType('article');

                        SeoHelper::setSeoOpenGraph($meta);

                        if (function_exists('admin_bar')) {
                            admin_bar()->registerLink(trans('modules.plugins.product::procategories.edit_this_procategory'),
                                route('procategories.edit', $procategory->id));
                        }

                        $allRelatedProCategoryIds = array_unique(array_merge(
                            $this->app->make(ProCategoryInterface::class)->getAllRelatedChildrenIds($procategory),
                            [$procategory->id]
                        ));

                        $products = $this->app->make(ProductInterface::class)->getByProCategory($allRelatedProCategoryIds, 12);

                        Theme::breadcrumb()->add(__('Home'), url('/'))
                            ->add($procategory->name, $procategory->url);

                        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, PROCATEGORY_MODULE_SCREEN_NAME, $procategory);

                        return [
                            'view'         => 'procategory',
                            'default_view' => 'modules.plugins.product::themes.procategory',
                            'data'         => compact('procategory', 'products'),
                            'slug'         => $procategory->slug,
                        ];
                    }
                    break;
            }
            if (!empty($data)) {
                return $data;
            }
        }

        return $slug;
    }

    /**
     * @param stdClass $shortcode
     * @return array|string
     * @throws FileNotFoundException
     * @throws Throwable
     */
    public function renderEcomerceProducts($shortcode)
    {
        $products = $this->app->make(ProductInterface::class)->getAllProducts($shortcode->paginate);

        $view = 'modules.plugins.product::themes.templates.products';
        $themeView = 'theme.' . setting('theme') . '::views.templates.products';
        if (view()->exists($themeView)) {
            $view = $themeView;
        }

        return view($view, compact('products'))->render();
    }

    /**
     * @param string|null $content
     * @param Page $page
     * @throws Throwable
     */
    public function renderProductPage(?string $content, Page $page)
    {
        if ($page->id == setting('product_page_id')) {
            $view = 'modules.plugins.product::themes.loop';

            if (view()->exists('theme.' . setting('theme') . '::views.loop')) {
                $view = 'theme.' . setting('theme') . '::views.loop';
            }
            return view($view, ['products' => get_all_products()])->render();
        }

        return $content;
    }

    /**
     * @param null $data
     * @return string
     * @throws Throwable
     */
    public function addSettings($data = null)
    {
        $pages = $this->app->make(PageInterface::class)
            ->allBy(['status' => BaseStatusEnum::PUBLISHED], [], ['pages.id', 'pages.name']);

        return $data . view('modules.plugins.product::settings', compact('pages'))->render();
    }

    /**
     * @param string|null $name
     * @param Page $page
     * @return string|null
     */
    public function addAdditionNameToPageName(?string $name, Page $page)
    {
        if ($page->id == setting('product_page_id')) {
            $subTitle = Html::tag('span', trans('modules.plugins.product::base.product_page'), ['class' => 'additional-page-name'])
                ->toHtml();
            if (Str::contains($name, '— ')) {
                return $name . ', ' . $subTitle;
            }

            return $name . '— ' . $subTitle;
        }

        return $name;
    }
}
