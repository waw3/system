<?php namespace Modules\Blog\Providers;

use Language, SeoHelper, SlugHelper, Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Shortcode\View\View;
use Modules\Base\Supports\Helper;
use Modules\Support\Traits\ModuleServiceProvider;
use Modules\Blog\Models\{Post, Category, Tag};
use Modules\Blog\Repositories\Caches\PostCacheDecorator;
use Modules\Blog\Repositories\Eloquent\PostRepository;
use Modules\Blog\Repositories\Interfaces\PostInterface;
use Modules\Blog\Repositories\Caches\CategoryCacheDecorator;
use Modules\Blog\Repositories\Eloquent\CategoryRepository;
use Modules\Blog\Repositories\Interfaces\CategoryInterface;
use Modules\Blog\Repositories\Caches\TagCacheDecorator;
use Modules\Blog\Repositories\Eloquent\TagRepository;
use Modules\Blog\Repositories\Interfaces\TagInterface;

/**
 * BlogServiceProvider class.
 *
 * @extends ServiceProvider
 */
class BlogServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Blog';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'blog';

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
        RouteServiceProvider::class
    ];

    /**
     * Register the composer classes.
     *
     * @var array
     */
    protected $composerViews = [
       //'backend.includes.sidebar' => \Modules\Blog\Http\Composers\Backend\Composer::class
    ];

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //
    ];

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Modules\Theme\Events\RenderingSiteMapEvent::class => [
            \Modules\Blog\Listeners\RenderingSiteMapListener::class,
        ],
    ];

    /**
     * Class event subscribers.
     *
     * @var array
     */
    protected $subscribe = [
        //
    ];

    /**
     * The command mappings for the application.
     *
     * @var array
     */
    protected $commands = [
        //\Modules\Blog\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        //\Modules\Blog\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
    ];

    /**
     * The application's global middleware groups.
     *
     * @var array
     */
    protected $middleware = [
        //
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
       //
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
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

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-plugins-blog',
                    'priority'    => 3,
                    'parent_id'   => null,
                    'name'        => 'modules.blog::base.menu_name',
                    'icon'        => 'fa fa-edit',
                    'url'         => route('posts.index'),
                    'permissions' => ['posts.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-blog-post',
                    'priority'    => 1,
                    'parent_id'   => 'cms-plugins-blog',
                    'name'        => 'modules.blog::posts.menu_name',
                    'icon'        => null,
                    'url'         => route('posts.index'),
                    'permissions' => ['posts.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-blog-categories',
                    'priority'    => 2,
                    'parent_id'   => 'cms-plugins-blog',
                    'name'        => 'modules.blog::categories.menu_name',
                    'icon'        => null,
                    'url'         => route('categories.index'),
                    'permissions' => ['categories.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-blog-tags',
                    'priority'    => 3,
                    'parent_id'   => 'cms-plugins-blog',
                    'name'        => 'modules.blog::tags.menu_name',
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
                'modules.blog::themes.post',
                'modules.blog::themes.category',
                'modules.blog::themes.tag',
            ], function (View $view) {
                $view->withShortcodes();
            });
        }
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
        $this->app->bind(PostInterface::class, function () {
            return new PostCacheDecorator(new PostRepository(new Post));
        });

        $this->app->bind(CategoryInterface::class, function () {
            return new CategoryCacheDecorator(new CategoryRepository(new Category));
        });

        $this->app->bind(TagInterface::class, function () {
            return new TagCacheDecorator(new TagRepository(new Tag));
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
