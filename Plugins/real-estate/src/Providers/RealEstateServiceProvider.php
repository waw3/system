<?php

namespace Modules\Plugins\RealEstate\Providers;

use Modules\Plugins\RealEstate\Commands\RenewPropertiesCommand;
use Modules\Plugins\RealEstate\Models\Consult;
use Modules\Plugins\RealEstate\Models\Currency;
use Modules\Plugins\RealEstate\Models\Category;
use Modules\Plugins\RealEstate\Repositories\Caches\ConsultCacheDecorator;
use Modules\Plugins\RealEstate\Repositories\Caches\CurrencyCacheDecorator;
use Modules\Plugins\RealEstate\Repositories\Caches\CategoryCacheDecorator;
use Modules\Plugins\RealEstate\Repositories\Eloquent\ConsultRepository;
use Modules\Plugins\RealEstate\Repositories\Eloquent\CurrencyRepository;
use Modules\Plugins\RealEstate\Repositories\Eloquent\CategoryRepository;
use Modules\Plugins\RealEstate\Repositories\Interfaces\ConsultInterface;
use Modules\Plugins\RealEstate\Repositories\Interfaces\CurrencyInterface;
use Modules\Plugins\RealEstate\Models\Investor;
use Modules\Plugins\RealEstate\Repositories\Caches\InvestorCacheDecorator;
use Modules\Plugins\RealEstate\Repositories\Eloquent\InvestorRepository;
use Modules\Plugins\RealEstate\Repositories\Interfaces\InvestorInterface;
use Modules\Plugins\RealEstate\Models\Project;
use Modules\Plugins\RealEstate\Models\Property;
use Modules\Plugins\RealEstate\Models\Feature;
use Modules\Plugins\RealEstate\Repositories\Caches\ProjectCacheDecorator;
use Modules\Plugins\RealEstate\Repositories\Caches\PropertyCacheDecorator;
use Modules\Plugins\RealEstate\Repositories\Caches\FeatureCacheDecorator;
use Modules\Plugins\RealEstate\Repositories\Eloquent\ProjectRepository;
use Modules\Plugins\RealEstate\Repositories\Eloquent\FeatureRepository;
use Modules\Plugins\RealEstate\Repositories\Eloquent\PropertyRepository;
use Modules\Plugins\RealEstate\Repositories\Interfaces\ProjectInterface;
use Modules\Plugins\RealEstate\Repositories\Interfaces\FeatureInterface;
use Modules\Plugins\RealEstate\Repositories\Interfaces\PropertyInterface;
use Modules\Plugins\RealEstate\Repositories\Interfaces\CategoryInterface;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Modules\Base\Supports\Helper;
use Event;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Language;
use MailVariable;
use SeoHelper;
use SlugHelper;

class RealEstateServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @var Application
     */
    protected $app;

    public function register()
    {
        $this->app->singleton(PropertyInterface::class, function () {
            return new PropertyCacheDecorator(
                new PropertyRepository(new Property)
            );
        });

        $this->app->singleton(ProjectInterface::class, function () {
            return new ProjectCacheDecorator(
                new ProjectRepository(new Project)
            );
        });

        $this->app->singleton(FeatureInterface::class, function () {
            return new FeatureCacheDecorator(
                new FeatureRepository(new Feature)
            );
        });

        $this->app->bind(InvestorInterface::class, function () {
            return new InvestorCacheDecorator(new InvestorRepository(new Investor));
        });

        $this->app->bind(CurrencyInterface::class, function () {
            return new CurrencyCacheDecorator(
                new CurrencyRepository(new Currency)
            );
        });

        $this->app->bind(ConsultInterface::class, function () {
            return new ConsultCacheDecorator(
                new ConsultRepository(new Consult)
            );
        });

        $this->app->bind(CategoryInterface::class, function () {
            return new CategoryCacheDecorator(
                new CategoryRepository(new Category)
            );
        });


        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('modules.plugins.real-estate')
            ->loadAndPublishConfigurations(['permissions', 'email'])
            ->loadMigrations()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-plugins-real-estate',
                    'priority'    => 5,
                    'parent_id'   => null,
                    'name'        => 'modules.plugins.real-estate::real-estate.name',
                    'icon'        => 'fa fa-bed',
                    'permissions' => ['projects.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-property',
                    'priority'    => 0,
                    'parent_id'   => 'cms-plugins-real-estate',
                    'name'        => 'modules.plugins.real-estate::property.name',
                    'icon'        => null,
                    'url'         => route('property.index'),
                    'permissions' => ['property.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-project',
                    'priority'    => 1,
                    'parent_id'   => 'cms-plugins-real-estate',
                    'name'        => 'modules.plugins.real-estate::project.name',
                    'icon'        => null,
                    'url'         => route('project.index'),
                    'permissions' => ['project.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-re-feature',
                    'priority'    => 2,
                    'parent_id'   => 'cms-plugins-real-estate',
                    'name'        => 'modules.plugins.real-estate::feature.name',
                    'icon'        => null,
                    'url'         => route('property_feature.index'),
                    'permissions' => ['property_feature.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-investor',
                    'priority'    => 3,
                    'parent_id'   => 'cms-plugins-real-estate',
                    'name'        => 'modules.plugins.real-estate::investor.name',
                    'icon'        => null,
                    'url'         => route('investor.index'),
                    'permissions' => ['investor.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-real-estate-settings',
                    'priority'    => 999,
                    'parent_id'   => 'cms-plugins-real-estate',
                    'name'        => 'modules.plugins.real-estate::real-estate.settings',
                    'icon'        => null,
                    'url'         => route('real-estate.settings'),
                    'permissions' => ['real-estate.settings'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-consult',
                    'priority'    => 6,
                    'parent_id'   => null,
                    'name'        => 'modules.plugins.real-estate::consult.name',
                    'icon'        => 'fas fa-headset',
                    'url'         => route('consult.index'),
                    'permissions' => ['consult.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-real-estate-category',
                    'priority' => 4,
                    'parent_id' => 'cms-plugins-real-estate',
                    'name' => 'modules.plugins.real-estate::category.name',
                    'icon' => null,
                    'url' => route('category.index'),
                    'permissions' => ['category.index'],
                ]);

        });

        $this->app->register(CommandServiceProvider::class);

        $this->app->booted(function () {
            $modules = [
                Property::class,
                Project::class,
            ];

            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule($modules);
                Language::registerModule([
                    Feature::class,
                    Investor::class,
                    Category::class,
                ]);
            }

            SlugHelper::registerModule($modules);
            SlugHelper::disablePreview($modules);
            SlugHelper::setPrefix(Project::class, 'projects');
            SlugHelper::setPrefix(Property::class, 'properties');

            SeoHelper::registerModule($modules);

            $this->app->make(Schedule::class)->command(RenewPropertiesCommand::class)->dailyAt('01:00');
        });

        $this->app->register(HookServiceProvider::class);

        MailVariable::setModule(REAL_ESTATE_MODULE_SCREEN_NAME)
            ->addVariables([
                'consult_name'    => __('Name'),
                'consult_phone'   => __('Phone'),
                'consult_email'   => __('Email'),
                'consult_content' => __('Content'),
                'consult_link'    => __('Link'),
                'consult_subject' => __('Subject'),
            ]);
    }
}
