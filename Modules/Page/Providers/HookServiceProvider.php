<?php

namespace Modules\Page\Providers;

use Auth, Theme, Throwable, SeoHelper, Menu, Eloquent;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Dashboard\Supports\DashboardWidgetInstance;
use Modules\Page\Models\Page;
use Modules\Page\Repositories\Interfaces\PageInterface;
use Modules\SeoHelper\Services\SeoOpenGraph;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (defined('MENU_ACTION_SIDEBAR_OPTIONS')) {
            add_action(MENU_ACTION_SIDEBAR_OPTIONS, [$this, 'registerMenuOptions'], 10);
        }
        add_filter('admin_dashboard_list', [$this, 'addPageStatsWidget'], 15, 2);
        add_filter(BASE_FILTER_PUBLIC_SINGLE_DATA, [$this, 'handleSingleView'], 1, 1);
        add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSetting'], 29, 1);
    }

    /**
     * Register sidebar options in menu
     * @throws Throwable
     */
    public function registerMenuOptions()
    {
        $pages = Menu::generateSelect([
            'model'   => $this->app->make(PageInterface::class)->getModel(),
            'type'    => Page::class,
            'theme'   => false,
            'options' => [
                'class' => 'list-item',
            ],
        ]);
        echo view('modules.page::partials.menu-options', compact('pages'));
    }

    /**
     * @param array $widgets
     * @param Collection $widget_settings
     * @return array
     *
     * @throws Throwable
     */
    public function addPageStatsWidget($widgets, $widgetSettings)
    {
        $pages = $this->app->make(PageInterface::class)->count(['status' => BaseStatusEnum::PUBLISHED]);

        return (new DashboardWidgetInstance)
            ->setType('stats')
            ->setPermission('pages.index')
            ->setTitle(trans('modules.page::pages.pages'))
            ->setKey('widget_total_pages')
            ->setIcon('far fa-file-alt')
            ->setColor('#32c5d2')
            ->setStatsTotal($pages)
            ->setRoute(route('pages.index'))
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

            if ($slug->reference_type === Page::class) {
                $page = $this->app->make(PageInterface::class)
                    ->getFirstBy($condition);
                if (!empty($page)) {
                    SeoHelper::setTitle($page->name)->setDescription($page->description);

                    $meta = new SeoOpenGraph;
                    if ($page->image) {
                        $meta->setImage(get_image_url($page->image));
                    }
                    $meta->setDescription($page->description);
                    $meta->setUrl($page->url);
                    $meta->setTitle($page->name);
                    $meta->setType('article');

                    SeoHelper::setSeoOpenGraph($meta);

                    if ($page->template) {
                        Theme::uses(setting('theme'))->layout($page->template);
                    }

                    admin_bar()
                        ->registerLink(trans('modules.page::pages.edit_this_page'), route('pages.edit', $page->id));

                    Theme::breadcrumb()
                        ->add(__('Home'), url('/'))
                        ->add($page->name, $page->url);

                    do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, PAGE_MODULE_SCREEN_NAME, $page);

                    $data = [
                        'view'         => 'page',
                        'default_view' => 'modules.page::themes.page',
                        'data'         => compact('page'),
                        'slug'         => $page->slug,
                    ];
                }
                if (!empty($data)) {
                    return $data;
                }
            }
        }

        return $slug;
    }

    /**
     * @param null $data
     * @return string
     * @throws Throwable
     */
    public function addSetting($data = null)
    {
        $pages = $this->app->make(PageInterface::class)
            ->allBy(['pages.status' => BaseStatusEnum::PUBLISHED], [], ['pages.id', 'pages.name']);

        return $data . view('modules.page::setting', compact('pages'))->render();
    }
}
