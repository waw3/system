<?php

namespace Modules\Plugins\Member\Providers;

use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Supports\Helper;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Modules\Plugins\Member\Http\Middleware\RedirectIfMember;
use Modules\Plugins\Member\Http\Middleware\RedirectIfNotMember;
use Modules\Plugins\Member\Models\Member;
use Modules\Plugins\Member\Models\MemberActivityLog;
use Modules\Plugins\Member\Repositories\Caches\MemberActivityLogCacheDecorator;
use Modules\Plugins\Member\Repositories\Caches\MemberCacheDecorator;
use Modules\Plugins\Member\Repositories\Eloquent\MemberActivityLogRepository;
use Modules\Plugins\Member\Repositories\Eloquent\MemberRepository;
use Modules\Plugins\Member\Repositories\Interfaces\MemberActivityLogInterface;
use Modules\Plugins\Member\Repositories\Interfaces\MemberInterface;
use Event;
use Illuminate\Support\ServiceProvider;
use MetaBox;

class MemberServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        config([
            'auth.guards.member'     => [
                'driver'   => 'session',
                'provider' => 'members',
            ],
            'auth.providers.members' => [
                'driver' => 'eloquent',
                'model'  => Member::class,
            ],
            'auth.passwords.members' => [
                'provider' => 'members',
                'table'    => 'member_password_resets',
                'expire'   => 60,
            ],
            'auth.guards.member-api' => [
                'driver'   => 'passport',
                'provider' => 'members',
            ],
        ]);

        $router = $this->app->make('router');

        $router->aliasMiddleware('member', RedirectIfNotMember::class);
        $router->aliasMiddleware('member.guest', RedirectIfMember::class);

        $this->app->bind(MemberInterface::class, function () {
            return new MemberCacheDecorator(new MemberRepository(new Member));
        });

        $this->app->bind(MemberActivityLogInterface::class, function () {
            return new MemberActivityLogCacheDecorator(new MemberActivityLogRepository(new MemberActivityLog));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('modules.plugins.member')
            ->loadAndPublishConfigurations(['general', 'permissions', 'assets'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web', 'api'])
            ->loadMigrations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-core-member',
                'priority'    => 22,
                'parent_id'   => null,
                'name'        => 'modules.plugins.member::member.menu_name',
                'icon'        => 'fa fa-users',
                'url'         => route('member.index'),
                'permissions' => ['member.index'],
            ]);
        });

        $this->app->register(EventServiceProvider::class);

        add_filter(IS_IN_ADMIN_FILTER, [$this, 'setInAdmin'], 20, 0);

        add_action('meta_boxes', function () {
            if (request()->segment(1) == 'account') {
                MetaBox::removeMetaBox('gallery_wrap', 'Modules\Plugins\Blog\Models\Post', 'advanced');
            }
        }, 12, 2);
    }

    /**
     * @return bool
     */
    public function setInAdmin(): bool
    {
        return in_array(request()->segment(1), ['account', mconfig('base.config.admin_dir')]);
    }
}
