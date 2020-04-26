<?php

namespace Modules\Plugins\Vendor\Providers;

use Modules\Plugins\Vendor\Models\Transaction;
use Modules\Plugins\Vendor\Repositories\Caches\TransactionCacheDecorator;
use Modules\Plugins\Vendor\Repositories\Eloquent\TransactionRepository;
use Modules\Plugins\Vendor\Repositories\Interfaces\TransactionInterface;
use Modules\Plugins\Vendor\Models\Package;
use Modules\Plugins\Vendor\Repositories\Caches\PackageCacheDecorator;
use Modules\Plugins\Vendor\Repositories\Eloquent\PackageRepository;
use Modules\Plugins\Vendor\Repositories\Interfaces\PackageInterface;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Supports\Helper;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Modules\Plugins\Vendor\Http\Middleware\RedirectIfVendor;
use Modules\Plugins\Vendor\Http\Middleware\RedirectIfNotVendor;
use Modules\Plugins\Vendor\Models\Vendor;
use Modules\Plugins\Vendor\Models\VendorActivityLog;
use Modules\Plugins\Vendor\Repositories\Caches\VendorActivityLogCacheDecorator;
use Modules\Plugins\Vendor\Repositories\Caches\VendorCacheDecorator;
use Modules\Plugins\Vendor\Repositories\Eloquent\VendorActivityLogRepository;
use Modules\Plugins\Vendor\Repositories\Eloquent\VendorRepository;
use Modules\Plugins\Vendor\Repositories\Interfaces\VendorActivityLogInterface;
use Modules\Plugins\Vendor\Repositories\Interfaces\VendorInterface;
use Event;
use Illuminate\Support\ServiceProvider;

class VendorServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        config([
            'auth.guards.vendor'     => [
                'driver'   => 'session',
                'provider' => 'vendors',
            ],
            'auth.providers.vendors' => [
                'driver' => 'eloquent',
                'model'  => Vendor::class,
            ],
            'auth.passwords.vendors' => [
                'provider' => 'vendors',
                'table'    => 'vendor_password_resets',
                'expire'   => 60,
            ],
            'auth.guards.vendor-api' => [
                'driver'   => 'passport',
                'provider' => 'vendors',
            ],
        ]);

        $router = $this->app->make('router');

        $router->aliasMiddleware('vendor', RedirectIfNotVendor::class);
        $router->aliasMiddleware('vendor.guest', RedirectIfVendor::class);
        $router->aliasMiddleware('vendor.media', VendorMediaMiddleware::class);

        $this->app->bind(VendorInterface::class, function () {
            return new VendorCacheDecorator(new VendorRepository(new Vendor));
        });

        $this->app->bind(VendorActivityLogInterface::class, function () {
            return new VendorActivityLogCacheDecorator(new VendorActivityLogRepository(new VendorActivityLog));
        });

        $this->app->bind(PackageInterface::class, function () {
            return new PackageCacheDecorator(
                new PackageRepository(new Package)
            );
        });

        $this->app->singleton(TransactionInterface::class, function () {
            return new TransactionCacheDecorator(new TransactionRepository(new Transaction));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('modules.plugins.vendor')
            ->loadAndPublishConfigurations(['general', 'permissions', 'assets'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web', 'api'])
            ->loadMigrations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-plugins-vendor',
                    'priority'    => 22,
                    'parent_id'   => null,
                    'name'        => 'modules.plugins.vendor::vendor.name',
                    'icon'        => 'fa fa-users',
                    'url'         => route('vendor.index'),
                    'permissions' => ['vendor.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-package',
                    'priority'    => 23,
                    'parent_id'   => null,
                    'name'        => 'modules.plugins.vendor::package.name',
                    'icon'        => 'fas fa-money-check-alt',
                    'url'         => route('package.index'),
                    'permissions' => ['package.index'],
                ]);

        });

        $this->app->register(EventServiceProvider::class);

        add_filter(IS_IN_ADMIN_FILTER, [$this, 'setInAdmin'], 20, 0);
    }

    /**
     * @return bool
     */
    public function setInAdmin(): bool
    {
        return in_array(request()->segment(1), ['account', mconfig('base.config.admin_dir')]);
    }
}
