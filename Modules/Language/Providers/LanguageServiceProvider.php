<?php namespace Modules\Language\Providers;

use Auth, Assets, Html, Event, Route, Theme, Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Routing\Events\RouteMatched;
use Yajra\DataTables\DataTableAbstract;
use Modules\Support\Traits\ModuleServiceProvider;
use Modules\Menu\Models\Menu;
use Modules\Language\Facades\LanguageFacade;
use Modules\Language\Models\Language as LanguageModel;
use Modules\Language\Models\LanguageMeta;
use Modules\Language\Repositories\Caches\LanguageMetaCacheDecorator;
use Modules\Language\Repositories\Eloquent\LanguageMetaRepository;
use Modules\Language\Repositories\Interfaces\LanguageMetaInterface;
use Modules\Language\Repositories\Caches\LanguageCacheDecorator;
use Modules\Language\Repositories\Eloquent\LanguageRepository;
use Modules\Language\Repositories\Interfaces\LanguageInterface;

/**
 * LanguageServiceProvider class.
 *
 * @extends ServiceProvider
 */
class LanguageServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Language';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'language';

    /**
     * currentLanguage
     *
     * @var mixed
     * @access protected
     */
    protected $currentLanguage;

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Modules\Base\Events\UpdatedContentEvent::class => [
            \Modules\Language\Listeners\UpdatedContentListener::class,
        ],
        \Modules\Base\Events\CreatedContentEvent::class => [
            \Modules\Language\Listeners\CreatedContentListener::class,
        ],
        \Modules\Base\Events\DeletedContentEvent::class => [
            \Modules\Language\Listeners\DeletedContentListener::class,
        ],
        \Modules\Theme\Events\ThemeRemoveEvent::class    => [
            \Modules\Language\Listeners\ThemeRemoveListener::class,
        ],
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        \Modules\Language\Console\Commands\SyncOldDataCommand::class => 'command.cms:language:sync'
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
        'localize' => \Modules\Language\Http\Middleware\LocalizationRoutes::class,
        'localizationRedirect' => \Modules\Language\Http\Middleware\LocalizationRedirectFilter::class,
        'localeSessionRedirect' => \Modules\Language\Http\Middleware\LocaleSessionRedirect::class
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
                'id'          => 'cms-plugins-language',
                'priority'    => 2,
                'parent_id'   => 'cms-core-settings',
                'name'        => 'modules.language::language.menu',
                'icon'        => null,
                'url'         => route('languages.index'),
                'permissions' => ['languages.index'],
            ]);

            Assets::addScriptsDirectly('vendor/core/plugins/language/js/language-global.js')
                ->addStylesDirectly(['vendor/core/plugins/language/css/language.css']);
        });

        $defaultLanguage = Language::getDefaultLanguage(['lang_id']);

        if (!empty($defaultLanguage)) {

            add_action('meta_boxes', [$this, 'addLanguageBox'], 50, 2);
            add_filter('slug-prefix-filter', [$this, 'setSlugPrefix'], 500, 1);
            add_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, [$this, 'addCurrentLanguageEditingAlert'], 55, 3);
            add_action(BASE_ACTION_BEFORE_EDIT_CONTENT, [$this, 'getCurrentAdminLanguage'], 55, 2);

            if (defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
                $this->app->booted(function () {
                    Theme::asset()->usePath(false)->add('language-css',asset('vendor/core/plugins/language/css/language-public.css'));
                    Theme::asset()->container('footer')->usePath(false)->add('language-public-js','vendor/core/plugins/language/js/language-public.js', ['jquery']);
                });
            }

            add_filter(BASE_FILTER_GET_LIST_DATA, [$this, 'addLanguageColumn'], 50, 2);
            add_filter(BASE_FILTER_TABLE_HEADINGS, [$this, 'addLanguageTableHeading'], 50, 2);
            add_filter(LANGUAGE_FILTER_SWITCHER, [$this, 'languageSwitcher']);
            add_filter(BASE_FILTER_BEFORE_GET_FRONT_PAGE_ITEM, [$this, 'checkItemLanguageBeforeShow'], 50, 2);

            if (setting('language_show_default_item_if_current_version_not_existed', true) && !is_in_admin())
                add_filter(BASE_FILTER_BEFORE_GET_SINGLE, [$this, 'getRelatedDataForOtherLanguage'], 50, 4);

            if (!is_in_admin())
                add_filter(BASE_FILTER_GROUP_PUBLIC_ROUTE, [$this, 'addLanguageMiddlewareToPublicRoute'], 958, 1);

            add_filter('base_filter_datatables_buttons', [$this, 'addLanguageSwitcherToTable'], 247, 2);
            add_filter('base_filter_datatables_query', [$this, 'getDataByCurrentLanguage'], 157, 2);
            add_filter('admin_dashboard_notifications', [$this, 'registerAdminAlert'], 2, 1);
            add_filter(BASE_FILTER_BEFORE_GET_ADMIN_LIST_ITEM, [$this, 'checkItemLanguageBeforeGetAdminListItem'], 50, 3);

            if (defined('THEME_OPTIONS_ACTION_META_BOXES'))
                add_filter(THEME_OPTIONS_ACTION_META_BOXES, [$this, 'addLanguageMetaBoxForThemeOptionsAndWidgets'], 55, 2);

            if (defined('WIDGET_TOP_META_BOXES'))
                add_filter(WIDGET_TOP_META_BOXES, [$this, 'addLanguageMetaBoxForThemeOptionsAndWidgets'], 55, 2);

            if (defined('THEME_FRONT_HEADER'))
                add_filter(THEME_FRONT_HEADER, [$this, 'addLanguageRefLangTags'], 55, 1);
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
        $this->app->bind(LanguageInterface::class, function () {
            return new LanguageCacheDecorator(new LanguageRepository(new LanguageModel));
        });

        $this->app->bind(LanguageMetaInterface::class, function () {
            return new LanguageMetaCacheDecorator(new LanguageMetaRepository(new LanguageMeta));
        });
    }

    /**
     * @param string $priority
     * @param $object
     */
    public function addLanguageBox($priority, $object)
    {
        if (!empty($object) && in_array(get_class($object), Language::supportedModels())) {
            add_meta_box('language_wrap', trans('modules.language::language.name'), [$this, 'languageMetaField'], get_class($object), 'top', 'default');
        }
    }

    /**
     * @param string $screen
     * @param $data
     * @return string
     * @throws \Throwable
     */
    public function addLanguageMetaBoxForThemeOptionsAndWidgets($data, $screen)
    {
        $route = null;
        switch ($screen) {
            case THEME_OPTIONS_MODULE_SCREEN_NAME:
                $route = 'theme.options';
                break;
            case WIDGET_MANAGER_MODULE_SCREEN_NAME:
                $route = 'widgets.index';
                break;
        }

        if (empty($route)) {
            return $data;
        }

        return $data . view('modules.language::partials.admin-list-language-chooser', compact('route'))->render();
    }

    /**
     * @param string $slug
     * @return string
     */
    public function setSlugPrefix(string $prefix)
    {
        if (is_in_admin()) {
            $currentLocale = Language::getCurrentAdminLocale();
        } else {
            $currentLocale = Language::getCurrentLocale();
        }

        if ($currentLocale && (!setting('language_hide_default') || $currentLocale != Language::getDefaultLocale())) {
            if (!$prefix) {
                return $currentLocale;
            }
            return $currentLocale . '/' . $prefix;
        }

        return $prefix;
    }

    /**
     * @throws \Throwable
     */
    public function languageMetaField()
    {
        $languages = Language::getActiveLanguage([
            'lang_code',
            'lang_flag',
            'lang_name',
        ]);

        if ($languages->isEmpty()) {
            return null;
        }

        $related = [];
        $value = null;
        $args = func_get_args();

        $meta = null;

        $currentRoute = explode('.', Route::currentRouteName());
        $route = [
            'create' => Route::currentRouteName(),
            'edit'   => $currentRoute[0] . '.' . 'edit',
        ];

        $request = $this->app->make('request');

        if ($args[0] && $args[0]->id) {
            $meta = $this->app->make(LanguageMetaInterface::class)->getFirstBy(
                [
                    'reference_id'   => $args[0]->id,
                    'reference_type' => get_class($args[0]),
                ],
                [
                    'lang_meta_code',
                    'reference_id',
                    'lang_meta_origin',
                ]
            );
            if (!empty($meta)) {
                $value = $meta->lang_meta_code;
            }

            $currentRoute = $currentRoute = explode('.', Route::currentRouteName());

            if (count($currentRoute) > 2) {
                $route = $currentRoute[0] . '.' . $currentRoute[1];
            } else {
                $route = $currentRoute[0];
            }

            $route = [
                'create' => $route . '.' . 'create',
                'edit'   => Route::currentRouteName(),
            ];
        } elseif ($request->input('ref_from')) {
            $meta = $this->app->make(LanguageMetaInterface::class)->getFirstBy(
                [
                    'reference_id'   => $request->input('ref_from'),
                    'reference_type' => get_class($args[0]),
                ],
                [
                    'lang_meta_code',
                    'reference_id',
                    'lang_meta_origin',
                ]
            );
            $value = $request->input('ref_lang');
        }
        if ($meta) {
            $related = Language::getRelatedLanguageItem($meta->reference_id, $meta->lang_meta_origin);
        }
        $currentLanguage = self::checkCurrentLanguage($languages, $value);

        if (!$currentLanguage) {
            $currentLanguage = Language::getDefaultLanguage([
                'lang_flag',
                'lang_name',
                'lang_code',
            ]);
        }

        $route = apply_filters(LANGUAGE_FILTER_ROUTE_ACTION, $route);
        return view('modules.language::language-box',
            compact('args', 'languages', 'currentLanguage', 'related', 'route'))->render();
    }

    /**
     * @param $value
     * @param $languages
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function checkCurrentLanguage($languages, $value)
    {
        $request = $this->app->make('request');
        $currentLanguage = null;
        foreach ($languages as $language) {
            if ($value) {
                if ($language->lang_code == $value) {
                    $currentLanguage = $language;
                }
            } else {
                if ($request->input('ref_lang')) {
                    if ($language->lang_code == $request->input('ref_lang')) {
                        $currentLanguage = $language;
                    }
                } elseif ($language->lang_is_default) {
                    $currentLanguage = $language;
                }
            }
        }

        if (empty($currentLanguage)) {
            foreach ($languages as $language) {
                if ($language->lang_is_default) {
                    $currentLanguage = $language;
                }
            }
        }

        return $currentLanguage;
    }

    /**
     * @param string $screen
     * @param \Illuminate\Http\Request $request
     * @param $data
     * @return void
     * @throws \Throwable
     * @since 2.1
     */
    public function addCurrentLanguageEditingAlert($screen, $request, $data = null)
    {
        if ($data && in_array(get_class($data), Language::supportedModels())) {
            $code = Language::getCurrentAdminLocaleCode();
            if (empty($code)) {
                $code = $this->getCurrentAdminLanguage($request, $data);
            }

            $language = null;
            if (!empty($code)) {
                Language::setCurrentAdminLocale($code);
                $language = $this->app->make(LanguageInterface::class)->getFirstBy(['lang_code' => $code],
                    ['lang_name']);
                if (!empty($language)) {
                    $language = $language->lang_name;
                }
            }
            echo view('modules.language::partials.notification', compact('language'))->render();
        }
        echo null;
    }

    /**
     * @param $screen
     * @param \Illuminate\Http\Request $request
     * @param \Eloquent | null $data
     * @return null|string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getCurrentAdminLanguage($request, $data = null)
    {
        $code = null;
        if ($request->has('ref_lang')) {
            $code = $request->input('ref_lang');
        } elseif (!empty($data)) {
            $meta = $this->app->make(LanguageMetaInterface::class)->getFirstBy([
                'reference_id'   => $data->id,
                'reference_type' => get_class($data),
            ], ['lang_meta_code']);
            if (!empty($meta)) {
                $code = $meta->lang_meta_code;
            }
        }

        if (empty($code)) {
            $code = Language::getDefaultLocaleCode();
        }

        Language::setCurrentAdminLocale($code);

        return $code;
    }

    /**
     * @param array $headings
     * @param $model
     * @return array
     */
    public function addLanguageTableHeading($headings, $model)
    {
        if (in_array(get_class($model), Language::supportedModels())) {
            $currentRoute = explode('.', Route::currentRouteName());

            if (count($currentRoute) > 2) {
                array_pop($currentRoute);
                $route = implode('.', $currentRoute);
            } else {
                $route = $currentRoute[0];
            }

            if (is_in_admin() && Auth::check() && !Auth::user()->hasAnyPermission([
                    $route . '.create',
                    $route . '.edit',
                ])) {
                return $headings;
            }

            $languages = Language::getActiveLanguage(['lang_code', 'lang_name', 'lang_flag']);
            $heading = '';
            foreach ($languages as $language) {
                $heading .= language_flag($language->lang_flag, $language->lang_name);
            }
            return array_merge($headings, [
                'language' => [
                    'name'       => 'language_meta.lang_meta_id',
                    'title'      => $heading,
                    'class'      => 'text-center language-header no-sort',
                    'width'      => (count($languages) * 40) . 'px',
                    'orderable'  => false,
                    'searchable' => false,
                ],
            ]);
        }
        return $headings;
    }

    /**
     * @param DataTableAbstract $data
     * @param $model
     * @return string
     */
    public function addLanguageColumn($data, $model)
    {
        if ($model && in_array(get_class($model), Language::supportedModels())) {
            $currentRoute = explode('.', Route::currentRouteName());

            if (count($currentRoute) > 2) {
                array_pop($currentRoute);
                $route = implode('.', $currentRoute);
            } else {
                $route = $currentRoute[0];
            }

            if (is_in_admin() && Auth::check() && !Auth::user()->hasAnyPermission([
                    $route . '.create',
                    $route . '.edit',
                ])) {
                return $data;
            }

            return $data->addColumn('language', function ($item) use ($model, $route) {
                $currentLanguage = $this->app->make(LanguageMetaInterface::class)->getFirstBy([
                    'reference_id'   => $item->id,
                    'reference_type' => get_class($item),
                ]);
                $relatedLanguages = [];
                if ($currentLanguage) {
                    $relatedLanguages = Language::getRelatedLanguageItem($currentLanguage->reference_id,
                        $currentLanguage->lang_meta_origin);
                    $currentLanguage = $currentLanguage->lang_meta_code;
                }
                $languages = Language::getActiveLanguage();
                $data = '';

                foreach ($languages as $language) {
                    if ($language->lang_code == $currentLanguage) {
                        $data .= view('modules.language::partials.status.active', compact('route', 'item'))->render();
                    } else {
                        $added = false;
                        if (!empty($relatedLanguages)) {
                            foreach ($relatedLanguages as $key => $relatedLanguage) {
                                if ($key == $language->lang_code) {
                                    $data .= view('modules.language::partials.status.edit',
                                        compact('route', 'relatedLanguage'))->render();
                                    $added = true;
                                }
                            }
                        }
                        if (!$added) {
                            $data .= view('modules.language::partials.status.plus',
                                compact('route', 'item', 'language'))->render();
                        }
                    }
                }

                return view('modules.language::partials.language-column', compact('data'))->render();
            });
        }

        return $data;
    }

    /**
     * @param array $options
     * @return string
     *
     * @throws \Throwable
     */
    public function languageSwitcher($options = [])
    {
        $supportedLocales = Language::getSupportedLocales();

        return view('modules.language::partials.switcher', compact('options', 'supportedLocales'))->render();
    }

    /**
     * @param EloquentBuilder $data
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return mixed
     */
    public function checkItemLanguageBeforeShow($data, $model)
    {
        return $this->getDataByCurrentLanguageCode($data, $model, Language::getCurrentLocaleCode());
    }

    /**
     * @param Builder $data
     * @param Model $model
     * @param $language_code
     * @return mixed
     */
    protected function getDataByCurrentLanguageCode($data, $model, $languageCode)
    {
        if (!empty($model) &&
            in_array(get_class($model), Language::supportedModels()) &&
            !empty($languageCode) &&
            !$model instanceof LanguageModel &&
            !$model instanceof LanguageMeta
        ) {
            if (Language::getCurrentAdminLocaleCode() !== 'all') {

                if ($model instanceof EloquentBuilder) {
                    $model = $model->getModel();
                }

                $table = $model->getTable();
                $data = $data
                    ->join('language_meta', 'language_meta.reference_id', $table . '.id')
                    ->where('language_meta.reference_type', '=', get_class($model))
                    ->where('language_meta.lang_meta_code', '=', $languageCode);
            }

            return $data;
        }

        return $data;
    }

    /**
     * @param EloquentBuilder $data
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return mixed
     */
    public function checkItemLanguageBeforeGetAdminListItem($data, $model)
    {
        return $this->getDataByCurrentLanguageCode($data, $model, Language::getCurrentAdminLocaleCode());
    }

    /**
     * @param Builder $query
     * @param EloquentBuilder $model
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getRelatedDataForOtherLanguage($query, $model)
    {
        if (in_array(get_class($model), Language::supportedModels()) &&
            !$model instanceof LanguageModel &&
            !$model instanceof LanguageMeta
        ) {
            $data = $query->first();

            if (!empty($data)) {
                $current = $this->app->make(LanguageMetaInterface::class)->getFirstBy([
                    'reference_type' => get_class($model),
                    'reference_id'   => $data->id,
                ]);
                if ($current) {
                    Language::setCurrentAdminLocale($current->lang_meta_code);
                    if ($current->lang_meta_code != Language::getCurrentLocaleCode()) {
                        if (setting('language_show_default_item_if_current_version_not_existed',
                                true) == false && get_class($model) != Menu::class) {
                            return $data;
                        }
                        $meta = $this->app->make(LanguageMetaInterface::class)->getModel()
                            ->where('lang_meta_origin', '=', $current->lang_meta_origin)
                            ->where('reference_id', '!=', $data->id)
                            ->where('lang_meta_code', '=', Language::getCurrentLocaleCode())
                            ->first();
                        if ($meta) {
                            $result = $model->where('id', '=', $meta->reference_id);
                            if ($result) {
                                return $result;
                            }
                        }
                    }
                }
            }
        }
        return $query;
    }

    /**
     * @param $data
     * @return array
     */
    public function addLanguageMiddlewareToPublicRoute($data)
    {
        return array_merge_recursive($data, [
            'prefix'     => Language::setLocale(),
            'middleware' => [
                'localeSessionRedirect',
                'localizationRedirect',
            ],
        ]);
    }

    /**
     * @param $buttons
     * @param $screen
     * @return array
     *
     * @since 2.2
     */
    public function addLanguageSwitcherToTable($buttons, $screen)
    {
        if (in_array($screen, Language::supportedModels())) {
            $activeLanguages = Language::getActiveLanguage(['lang_code', 'lang_name', 'lang_flag']);
            $languageButtons = [];
            $currentLanguage = Language::getCurrentAdminLocaleCode();
            foreach ($activeLanguages as $item) {
                $languageButtons[] = [
                    'className' => 'change-data-language-item ' . ($item->lang_code == $currentLanguage ? 'active' : ''),
                    'text'      => Html::tag('span', $item->lang_name,
                        ['data-href' => route('languages.change.data.language', $item->lang_code)])->toHtml(),
                ];
            }

            $languageButtons[] = [
                'className' => 'change-data-language-item ' . ('all' == $currentLanguage ? 'active' : ''),
                'text'      => Html::tag('span', trans('modules.language::language.show_all'),
                    ['data-href' => route('languages.change.data.language', 'all')])->toHtml(),
            ];

            $flag = $activeLanguages->where('lang_code', $currentLanguage)->first();
            if (!empty($flag)) {
                $flag = language_flag($flag->lang_flag, $flag->lang_name);
            } else {
                $flag = Html::tag('i', '', ['class' => 'fa fa-flag'])->toHtml();
            }

            $language = [
                'language' => [
                    'extend'  => 'collection',
                    'text'    => $flag . Html::tag('span',
                            ' ' . trans('modules.language::language.change_language') . ' ' . Html::tag('span', '',
                                ['class' => 'caret'])->toHtml())->toHtml(),
                    'buttons' => $languageButtons,
                ],
            ];
            $buttons = array_merge($buttons, $language);
        }

        return $buttons;
    }

    /**
     * @param Builder $query
     * @param Model $model
     * @return mixed
     *
     * @since 2.2
     */
    public function getDataByCurrentLanguage($query, $model)
    {
        if ($model && in_array(get_class($model),
                Language::supportedModels()) && Language::getCurrentAdminLocaleCode()) {

            if (Language::getCurrentAdminLocaleCode() !== 'all') {
                /**
                 * @var \Eloquent $model
                 */
                $table = $model->getTable();
                $query = $query
                    ->join('language_meta', 'language_meta.reference_id', $table . '.id')
                    ->where('language_meta.reference_type', '=', get_class($model))
                    ->where('language_meta.lang_meta_code', '=', Language::getCurrentAdminLocaleCode());
            }
        }

        return $query;
    }

    /**
     * @param string $alert
     * @return string
     *
     * @throws \Throwable
     */
    public function registerAdminAlert($alert)
    {
        return $alert . view('modules.language::partials.admin-language-switcher')->render();
    }

    /**
     * @param string|null $header
     * @return string
     * @throws \Throwable
     */
    public function addLanguageRefLangTags($header)
    {
        $supportedLocales = Language::getSupportedLocales();

        return $header . view('modules.language::partials.hreflang', compact('supportedLocales'))->render();
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
