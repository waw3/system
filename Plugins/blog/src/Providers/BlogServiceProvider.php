<?php

namespace Modules\Plugins\Blog\Providers;

use Language, SeoHelper, SlugHelper, Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Shortcode\View\View;
use Modules\Base\Supports\Helper;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Modules\Plugins\Blog\Models\{Post, Category, Tag};
use Modules\Plugins\Blog\Repositories\Caches\PostCacheDecorator;
use Modules\Plugins\Blog\Repositories\Eloquent\PostRepository;
use Modules\Plugins\Blog\Repositories\Interfaces\PostInterface;
use Modules\Plugins\Blog\Repositories\Caches\CategoryCacheDecorator;
use Modules\Plugins\Blog\Repositories\Eloquent\CategoryRepository;
use Modules\Plugins\Blog\Repositories\Interfaces\CategoryInterface;
use Modules\Plugins\Blog\Repositories\Caches\TagCacheDecorator;
use Modules\Plugins\Blog\Repositories\Eloquent\TagRepository;
use Modules\Plugins\Blog\Repositories\Interfaces\TagInterface;


/**
 * BlogServiceProvider class.
 *
 * @extends ServiceProvider
 */
class BlogServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * register function.
     *
     * @access public
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostInterface::class, function () {
            return new PostCacheDecorator(new PostRepository(new Post));
        });

        $this->app->bind(CategoryInterface::class, function () {
            return new CategoryCacheDecorator(new CategoryRepository(new Category));
        });

        $this->app->bind(TagInterface::class, function () {
            return new TagCacheDecorator(new TagRepository(new Tag));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    /**
     * boot function.
     *
     * @access public
     * @return void
     */
    public function boot()
    {
        $this->setNamespace('modules.plugins.blog')
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
                    'id'          => 'cms-plugins-blog',
                    'priority'    => 3,
                    'parent_id'   => null,
                    'name'        => 'modules.plugins.blog::base.menu_name',
                    'icon'        => 'fa fa-edit',
                    'url'         => route('posts.index'),
                    'permissions' => ['posts.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-blog-post',
                    'priority'    => 1,
                    'parent_id'   => 'cms-plugins-blog',
                    'name'        => 'modules.plugins.blog::posts.menu_name',
                    'icon'        => null,
                    'url'         => route('posts.index'),
                    'permissions' => ['posts.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-blog-categories',
                    'priority'    => 2,
                    'parent_id'   => 'cms-plugins-blog',
                    'name'        => 'modules.plugins.blog::categories.menu_name',
                    'icon'        => null,
                    'url'         => route('categories.index'),
                    'permissions' => ['categories.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-blog-tags',
                    'priority'    => 3,
                    'parent_id'   => 'cms-plugins-blog',
                    'name'        => 'modules.plugins.blog::tags.menu_name',
                    'icon'        => null,
                    'url'         => route('tags.index'),
                    'permissions' => ['tags.index'],
                ]);
        });

        theme_option()->setSection([
            'title'      => __('Blog'),
            'desc'       => __('Blog settings'),
            'id'         => 'opt-text-subsection-blog',
            'subsection' => true,
            'icon'       => 'fa fa-edit',
            'priority'   => 500,
            'fields'     => [
                [
                    'id'         => 'number_of_posts_in_a_category',
                    'type'       => 'text',
                    'label'      => __('Number of posts in a category'),
                    'attributes' => [
                        'name'    => 'number_of_posts_in_a_category',
                        'value'   => '12',
                        'options' => [
                            'class'        => 'form-control',
                            'placeholder'  => '',
                            'data-counter' => 400,
                        ],
                    ],
                ],

                [
                    'id'         => 'number_of_posts_in_a_tag',
                    'type'       => 'text',
                    'label'      => __('Number of posts in a tag'),
                    'attributes' => [
                        'name'    => 'number_of_posts_in_a_tag',
                        'value'   => '12',
                        'options' => [
                            'class'        => 'form-control',
                            'placeholder'  => '',
                            'data-counter' => 120,
                        ],
                    ],
                ],
            ],
        ]);

        $this->app->booted(function () {
            $models = [Post::class, Category::class, Tag::class];

            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule($models);
            }

            SlugHelper::registerModule($models);
            SlugHelper::setPrefix(Tag::class, 'tag');

            SeoHelper::registerModule($models);
        });

        if (function_exists('shortcode')) {
            view()->composer([
                'modules.plugins.blog::themes.post',
                'modules.plugins.blog::themes.category',
                'modules.plugins.blog::themes.tag',
            ], function (View $view) {
                $view->withShortcodes();
            });
        }
    }
}
