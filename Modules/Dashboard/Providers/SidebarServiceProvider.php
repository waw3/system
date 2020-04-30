<?php namespace Modules\Dashboard\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Sidebar\SidebarManager;
use Modules\Dashboard\Sidebar\DashboardSidebar;
use Modules\Dashboard\Http\ViewCreators\DashboardSidebarCreator;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(SidebarManager $manager)
    {
        if (!app('isInstalled')) {
            return;
        }

        if (app('onBackend')) {
            $manager->register(DashboardSidebar::class);
        }

        View::creator('modules.dashboard::partials.sidebar', DashboardSidebarCreator::class);
    }
}
