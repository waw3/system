<?php namespace Modules\CustomField\Providers;

use Event, CustomField;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Foundation\AliasLoader;
use Modules\Acl\Repositories\Interfaces\RoleInterface;
use Modules\Acl\Repositories\Interfaces\UserInterface;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Post;
use Modules\Page\Models\Page;
use Modules\Support\Traits\ModuleServiceProvider;
use Modules\Page\Repositories\Interfaces\PageInterface;
use Modules\CustomField\Repositories\Caches\CustomFieldCacheDecorator;
use Modules\CustomField\Repositories\Eloquent\CustomFieldRepository;
use Modules\CustomField\Repositories\Caches\FieldGroupCacheDecorator;
use Modules\CustomField\Repositories\Eloquent\FieldGroupRepository;
use Modules\CustomField\Repositories\Caches\FieldItemCacheDecorator;
use Modules\CustomField\Repositories\Eloquent\FieldItemRepository;
use Modules\CustomField\Repositories\Interfaces\CustomFieldInterface;
use Modules\CustomField\Repositories\Interfaces\FieldGroupInterface;
use Modules\CustomField\Repositories\Interfaces\FieldItemInterface;



/**
 * CustomFieldServiceProvider class.
 *
 * @extends ServiceProvider
 */
class CustomFieldServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'CustomField';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'custom-field';

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
       //'backend.includes.sidebar' => \Modules\CustomField\Http\Composers\Backend\Composer::class
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
        \Modules\Base\Events\UpdatedContentEvent::class => [
            \Modules\CustomField\Listeners\UpdatedContentListener::class,
        ],
        \Modules\Base\Events\CreatedContentEvent::class => [
            \Modules\CustomField\Listeners\CreatedContentListener::class,
        ],
        \Modules\Base\Events\DeletedContentEvent::class => [
            \Modules\CustomField\Listeners\DeletedContentListener::class,
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
                'id'          => 'cms-plugins-custom-field',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'modules.custom-field::base.admin_menu.title',
                'icon'        => 'fas fa-cubes',
                'url'         => route('custom-fields.index'),
                'permissions' => ['custom-fields.index'],
            ]);

            $this->registerUsersFields();
            $this->registerPagesFields();
            $this->registerBlogFields();
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

        $this->app->bind('CustomField', function ($app) {
            return new \Modules\CustomField\Services\CustomField();
        });


        $this->app->bind(CustomFieldInterface::class, function () {
            return new CustomFieldCacheDecorator(
                new CustomFieldRepository(new \Modules\CustomField\Models\CustomField),
                CUSTOM_FIELD_CACHE_GROUP
            );
        });

        $this->app->bind(FieldGroupInterface::class, function () {
            return new FieldGroupCacheDecorator(
                new FieldGroupRepository(new \Modules\CustomField\Models\FieldGroup),
                CUSTOM_FIELD_CACHE_GROUP
            );
        });

        $this->app->bind(FieldItemInterface::class, function () {
            return new FieldItemCacheDecorator(
                new FieldItemRepository(new \Modules\CustomField\Models\FieldItem),
                CUSTOM_FIELD_CACHE_GROUP
            );
        });
    }

    /**
     * @return CustomField
     */
    protected function registerUsersFields()
    {
        return CustomField::registerRule('other', trans('modules.custom-field::rules.logged_in_user'), 'logged_in_user', function () {
                $users = $this->app->make(UserInterface::class)->all();
                $userArr = [];
                foreach ($users as $user) {
                    $userArr[$user->id] = $user->username . ' - ' . $user->email;
                }

                return $userArr;
            })
            ->registerRule('other', trans('modules.custom-field::rules.logged_in_user_has_role'), 'logged_in_user_has_role', function () {
                $roles = $this->app->make(RoleInterface::class)->all();
                $rolesArr = [];
                foreach ($roles as $role) {
                    $rolesArr[$role->slug] = $role->name . ' - (' . $role->slug . ')';
                }

                return $rolesArr;
            });
    }

    /**
     * @return CustomField|bool
     */
    protected function registerPagesFields()
    {
        if (!defined('PAGE_MODULE_SCREEN_NAME')) {
            return false;
        }

        return CustomField::registerRule('basic', trans('modules.custom-field::rules.page_template'),
            'page_template', function () {
                return get_page_templates();
            })
            ->registerRule('basic', trans('modules.custom-field::rules.page'), Page::class, function () {
                return $this->app->make(PageInterface::class)
                    ->advancedGet([
                        'select'   => [
                            'id',
                            'name',
                        ],
                        'order_by' => [
                            'created_at' => 'DESC',
                        ],
                    ])
                    ->pluck('name', 'id')
                    ->toArray();
            })
            ->registerRule('other', trans('modules.custom-field::rules.model_name'), 'model_name', function () {
                return [
                    Page::class => trans('modules.custom-field::rules.model_name_page'),
                ];
            });
    }

    /**
     * @return bool|CustomField
     */
    protected function registerBlogFields()
    {
        if (!defined('POST_MODULE_SCREEN_NAME')) {
            return false;
        }

        $categories = get_categories();

        $categoriesArr = [];
        foreach ($categories as $row) {
            $categoriesArr[$row->id] = $row->indent_text . ' ' . $row->name;
        }

        return CustomField::registerRuleGroup('blog')
            ->registerRule('blog', trans('modules.custom-field::rules.category'), Category::class,
                function () use ($categoriesArr) {
                    return $categoriesArr;
                })
            ->registerRule('blog', trans('modules.custom-field::rules.post_with_related_category'),
                Post::class . '_post_with_related_category', function () use ($categoriesArr) {
                    return $categoriesArr;
                })
            ->registerRule('blog', trans('modules.custom-field::rules.post_format'),
                Post::class . '_post_format', function () {
                    $formats = [];
                    foreach (get_post_formats() as $key => $format) {
                        $formats[$key] = $format['name'];
                    }
                    return $formats;
                })
            ->expandRule('other', trans('modules.custom-field::rules.model_name'), 'model_name', function () {
                return [
                    Post::class     => trans('modules.custom-field::rules.model_name_post'),
                    Category::class => trans('modules.custom-field::rules.model_name_category'),
                ];
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
