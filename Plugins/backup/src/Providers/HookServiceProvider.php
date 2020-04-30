<?php

namespace Modules\Plugins\Backup\Providers;

use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (app()->environment('demo')) {
            add_filter('admin_dashboard_notifications', [$this, 'registerAdminAlert'], 5, 1);
        }

        add_filter('base-filter-after-setting-content', [$this, 'addBackupSetting'], 199, 1);
    }

    /**
     * @param string $alert
     * @return string
     *
     * @throws \Throwable
     */
    public function registerAdminAlert($alert)
    {
        return $alert . view('modules.plugins.backup::partials.admin-alert')->render();
    }

    /**
     * @param null $data
     * @return string
     * @throws \Throwable
     *
     */
    public function addBackupSetting($data = null)
    {
        return $data . view('modules.plugins.backup::setting')->render();
    }
}
