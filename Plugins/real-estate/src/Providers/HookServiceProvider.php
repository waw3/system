<?php

namespace Modules\Plugins\RealEstate\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Modules\Plugins\RealEstate\Repositories\Interfaces\ConsultInterface;
use Throwable;

class HookServiceProvider extends ServiceProvider
{
    /**
     * @throws Throwable
     */
    public function boot()
    {
        add_filter('base_filter_top_header_layout', [$this, 'registerTopHeaderNotification'], 130);
        add_filter('base_filter_append_menu_name', [$this, 'getUnReadCount'], 130, 2);
        add_filter('base-filter-after-setting-email-content', [$this, 'addConsultSetting'], 990, 1);
    }

    /**
     * @param string $options
     * @return string
     *
     * @throws Throwable
     */
    public function registerTopHeaderNotification($options)
    {
        if (Auth::user()->hasPermission('consults.edit')) {
            $consults = $this->app->make(ConsultInterface::class)
                ->getUnread(['id', 'name', 'email', 'phone', 'created_at']);

            if ($consults->count() == 0) {
                return null;
            }

            return $options . view('modules.plugins.real-estate::notification', compact('consults'))->render();
        }
        return null;
    }

    /**
     * @param $number
     * @param $menuId
     * @return string
     * @throws BindingResolutionException
     */
    public function getUnReadCount($number, $menuId)
    {
        if ($menuId == 'cms-plugins-consult') {
            $unread = $this->app->make(ConsultInterface::class)->countUnread();
            if ($unread > 0) {
                return '<span class="badge badge-success">' . $unread . '</span>';
            }
        }

        return $number;
    }

    /**
     * @param null $data
     * @return string
     * @throws Throwable
     */
    public function addConsultSetting($data = null)
    {
        return $data . view('modules.plugins.real-estate::setting')->render();
    }
}
