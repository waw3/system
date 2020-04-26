<?php

namespace Modules\Base\Providers;

use Assets;
use Illuminate\Support\Facades\Auth;
use Modules\Acl\Models\UserMeta;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use RvMedia;

class ComposerServiceProvider extends ServiceProvider
{

    /**
     * @param Factory $view
     */
    public function boot(Factory $view)
    {
        $view->composer(['modules.base::layouts.partials.top-header'], function (View $view) {
            $themes = Assets::getThemes();
            $locales = Assets::getAdminLocales();

            if (Auth::check() && !session()->has('admin-theme')) {
                $activeTheme = UserMeta::getMeta('admin-theme', mconfig('base.config.default-theme'));
            } elseif (session()->has('admin-theme')) {
                $activeTheme = session('admin-theme');
            } else {
                $activeTheme = mconfig('base.config.default-theme');
            }

            if (!array_key_exists($activeTheme, $themes)) {
                $activeTheme = mconfig('base.config.default-theme');
            }

            if (array_key_exists($activeTheme, $themes)) {
                Assets::addStylesDirectly($themes[$activeTheme]);
            }

            session(['admin-theme' => $activeTheme]);

            $view->with(compact('themes', 'locales', 'activeTheme'));
        });

        $view->composer(['modules.acl::auth.master'], function (View $view) {
            $themes = Assets::getThemes();
            $activeTheme = mconfig('base.config.default-theme');

            if (array_key_exists($activeTheme, $themes)) {
                Assets::addStylesDirectly($themes[$activeTheme]);
            }

            $view->with(compact('themes', 'activeTheme'));
        });

        $view->composer(['modules.media::config'], function () {
            $mediaPermissions = mconfig('media.config.permissions');
            if (Auth::check() && !Auth::user()->isSuperUser()) {
                $mediaPermissions = array_intersect(array_keys(Auth::user()->permissions),
                    mconfig('media.config.permissions'));
            }
            RvMedia::setPermissions($mediaPermissions);
        });
    }
}
