<?php

namespace Modules\Blog\Providers;

use Auth, Assets, Menu, Theme, Throwable, stdClass, SeoHelper, Event, Html, Eloquent;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Post;
use Modules\Blog\Models\Tag;
use Modules\Dashboard\Supports\DashboardWidgetInstance;
use Modules\Base\Supports\Helper;
use Modules\Page\Models\Page;
use Modules\Page\Repositories\Interfaces\PageInterface;
use Modules\SeoHelper\Services\SeoOpenGraph;
use Modules\Blog\Repositories\Interfaces\CategoryInterface;
use Modules\Blog\Repositories\Interfaces\TagInterface;
use Modules\Blog\Repositories\Interfaces\PostInterface;

/**
 * HookServiceProvider class.
 *
 * @extends ServiceProvider
 */
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
            add_filter(PAGE_FILTER_FRONT_PAGE_CONTENT, [$this, 'renderBlogPage'], 2, 2);
            add_filter('base-filter-after-setting-content', [$this, 'addSettings'], 47, 1);
            add_filter(PAGE_FILTER_PAGE_NAME_IN_ADMIN_LIST, [$this, 'addAdditionNameToPageName'], 147, 2);
        }

        if (function_exists('admin_bar')) {
            Event::listen(RouteMatched::class, function () {
                admin_bar()->registerLink('Post', route('posts.create'), 'add-new');
            });
        }

        if (function_exists('add_shortcode')) {
            add_shortcode('blog-posts', __('Blog posts'), __('Add blog posts'), [$this, 'renderBlogPosts']);
            shortcode()->setAdminConfig('blog-posts', view('modules.blog::partials.posts-short-code-admin-config')->render());
        }
    }

    /**
     * Register sidebar options in menu
     * @throws Throwable
     */
    public function registerMenuOptions()
    {
        if (Auth::user()->hasPermission('categories.index')) {
            $categories = Menu::generateSelect([
                'model'   => $this->app->make(CategoryInterface::class)->getModel(),
                'type'    => Category::class,
                'theme'   => false,
                'options' => [
                    'class' => 'list-item',
                ],
            ]);
            echo view('modules.blog::categories.menu-options', compact('categories'));
        }

        if (Auth::user()->hasPermission('tags.index')) {
            $tags = Menu::generateSelect([
                'model'   => $this->app->make(TagInterface::class)->getModel(),
                'type'    => Tag::class,
                'theme'   => false,
                'options' => [
                    'class' => 'list-item',
                ],
            ]);
            echo view('modules.blog::tags.partials.menu-options', compact('tags'));
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
        if (!Auth::user()->hasPermission('posts.index')) {
            return $widgets;
        }

        Assets::addScriptsDirectly(['/vendor/core/plugins/blog/js/blog.js']);

        return (new DashboardWidgetInstance)
            ->setPermission('posts.index')
            ->setKey('widget_posts_recent')
            ->setTitle(trans('modules.blog::posts.widget_posts_recent'))
            ->setIcon('fas fa-edit')
            ->setColor('#f3c200')
            ->setRoute(route('posts.widget.recent-posts'))
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
                case Post::class:
                    $post = $this->app->make(PostInterface::class)
                        ->getFirstBy($condition, ['*'],
                            ['categories', 'tags', 'slugable', 'categories.slugable', 'tags.slugable']);

                    if (!empty($post)) {
                        Helper::handleViewCount($post, 'viewed_post');

                        SeoHelper::setTitle($post->name)->setDescription($post->description);

                        $meta = new SeoOpenGraph;
                        if ($post->image) {
                            $meta->setImage(get_image_url($post->image));
                        }
                        $meta->setDescription($post->description);
                        $meta->setUrl($post->url);
                        $meta->setTitle($post->name);
                        $meta->setType('article');

                        SeoHelper::setSeoOpenGraph($meta);

                        if (function_exists('admin_bar')) {
                            admin_bar()->registerLink(trans('modules.blog::posts.edit_this_post'), route('posts.edit', $post->id));
                        }

                        Theme::breadcrumb()->add(__('Home'), url('/'))->add($post->name, $post->url);

                        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, POST_MODULE_SCREEN_NAME, $post);

                        $data = [
                            'view'         => 'post',
                            'default_view' => 'modules.blog::themes.post',
                            'data'         => compact('post'),
                            'slug'         => $post->slug,
                        ];
                    }
                    break;
                case Category::class:
                    $category = $this->app->make(CategoryInterface::class)
                        ->getFirstBy($condition, ['*'], ['slugable']);
                    if (!empty($category)) {
                        SeoHelper::setTitle($category->name)->setDescription($category->description);

                        $meta = new SeoOpenGraph;
                        if ($category->image) {
                            $meta->setImage(get_image_url($category->image));
                        }
                        $meta->setDescription($category->description);
                        $meta->setUrl($category->url);
                        $meta->setTitle($category->name);
                        $meta->setType('article');

                        SeoHelper::setSeoOpenGraph($meta);

                        if (function_exists('admin_bar')) {
                            admin_bar()->registerLink(trans('modules.blog::categories.edit_this_category'),
                                route('categories.edit', $category->id));
                        }

                        $allRelatedCategoryIds = array_unique(array_merge(
                            $this->app->make(CategoryInterface::class)->getAllRelatedChildrenIds($category),
                            [$category->id]
                        ));

                        $posts = $this->app->make(PostInterface::class)->getByCategory($allRelatedCategoryIds, 12);

                        Theme::breadcrumb()->add(__('Home'), url('/'))->add($category->name, $category->url);

                        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, CATEGORY_MODULE_SCREEN_NAME, $category);

                        return [
                            'view'         => 'category',
                            'default_view' => 'modules.blog::themes.category',
                            'data'         => compact('category', 'posts'),
                            'slug'         => $category->slug,
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
    public function renderBlogPosts($shortcode)
    {
        $posts = $this->app->make(PostInterface::class)->getAllPosts($shortcode->paginate);

        $view = 'modules.blog::themes.templates.posts';
        $themeView = 'theme.' . setting('theme') . '::views.templates.posts';
        if (view()->exists($themeView)) {
            $view = $themeView;
        }

        return view($view, compact('posts'))->render();
    }

    /**
     * @param string|null $content
     * @param Page $page
     * @throws Throwable
     */
    public function renderBlogPage(?string $content, Page $page)
    {
        if ($page->id == setting('blog_page_id')) {
            $view = 'modules.blog::themes.loop';

            if (view()->exists('theme.' . setting('theme') . '::views.loop')) {
                $view = 'theme.' . setting('theme') . '::views.loop';
            }
            return view($view, ['posts' => get_all_posts()])->render();
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

        return $data . view('modules.blog::settings', compact('pages'))->render();
    }

    /**
     * @param string|null $name
     * @param Page $page
     * @return string|null
     */
    public function addAdditionNameToPageName(?string $name, Page $page)
    {
        if ($page->id == setting('blog_page_id')) {
            $subTitle = Html::tag('span', trans('modules.blog::base.blog_page'), ['class' => 'additional-page-name'])
                ->toHtml();
            if (Str::contains($name, '— ')) {
                return $name . ', ' . $subTitle;
            }

            return $name . '— ' . $subTitle;
        }

        return $name;
    }
}
