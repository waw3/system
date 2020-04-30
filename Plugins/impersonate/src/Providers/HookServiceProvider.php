<?php

namespace Modules\Plugins\Impersonate\Providers;

use Modules\ACL\Models\User;
use Modules\ACL\Repositories\Interfaces\ActivationInterface;
use Html;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{

    public function boot()
    {
        add_filter('user_table_actions', [$this, 'addImpersonateButton'], 120, 2);
        add_filter('base_filter_top_header_layout', [$this, 'addLeaveImpersonateButton'], 120, 1);
    }

    /**
     * @param User $user
     * @param string $actions
     * @return string
     */
    public function addImpersonateButton($actions, User $user)
    {
        $impersonate = null;
        if (Auth::user()->hasPermission('users.impersonate')) {
            $impersonate = Html::tag(
                'button',
                trans('modules.plugins.impersonate::impersonate.login_as_this_user'),
                ['class' => 'btn btn-warning', 'disabled' => true]
            )->toHtml();

            if (Auth::user()->id !== $user->id && app(ActivationInterface::class)->completed($user)) {
                $impersonate = Html::link(
                    route('users.impersonate', $user->id),
                    trans('modules.plugins.impersonate::impersonate.login_as_this_user'),
                    ['class' => 'btn btn-warning']
                )->toHtml();
            }
        }

        return $impersonate . $actions;
    }

    /**
     * @param string $html
     * @return string
     * @throws \Throwable
     */
    public function addLeaveImpersonateButton($html): string
    {
        return view('modules.plugins.impersonate::leave-impersonate')->render() . $html;
    }
}
