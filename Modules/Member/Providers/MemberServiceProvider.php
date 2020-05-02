<?php namespace Modules\Member\Providers;

use Event, MetaBox;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Supports\Helper;
use Modules\Support\Traits\ModuleServiceProvider;
use Modules\Member\Models\Member;
use Modules\Member\Models\MemberActivityLog;
use Modules\Member\Repositories\Caches\MemberActivityLogCacheDecorator;
use Modules\Member\Repositories\Caches\MemberCacheDecorator;
use Modules\Member\Repositories\Eloquent\MemberActivityLogRepository;
use Modules\Member\Repositories\Eloquent\MemberRepository;
use Modules\Member\Repositories\Interfaces\MemberActivityLogInterface;
use Modules\Member\Repositories\Interfaces\MemberInterface;

/**
 * MemberServiceProvider class.
 *
 * @extends ServiceProvider
 */
class MemberServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Member';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'member';

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
     * Register the composer classes.
     *
     * @var array
     */
    protected $composerViews = [
       //'backend.includes.sidebar' => \Modules\Member\Http\Composers\Backend\Composer::class
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
            \Modules\Member\Listeners\UpdatedContentListener::class,
        ],
    ];


    /**
     * Class event subscribers.
     *
     * @var array
     */
    protected $subscribe = [
        //
    ];

    /**
     * The command mappings for the application.
     *
     * @var array
     */
    protected $commands = [
        //\Modules\Member\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        //\Modules\Member\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
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
        'member' => \Modules\Member\Http\Middleware\RedirectIfNotMember::class,
        'member.guest' => \Modules\Member\Http\Middleware\RedirectIfMember::class
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
                'id'          => 'cms-core-member',
                'priority'    => 22,
                'parent_id'   => null,
                'name'        => 'modules.member::member.menu_name',
                'icon'        => 'fa fa-users',
                'url'         => route('member.index'),
                'permissions' => ['member.index'],
            ]);
        });

        add_filter(IS_IN_ADMIN_FILTER, [$this, 'setInAdmin'], 20, 0);

        add_action('meta_boxes', function () {
            if (request()->segment(1) == 'account') {
                MetaBox::removeMetaBox('gallery_wrap', 'Modules\Blog\Models\Post', 'advanced');
            }
        }, 12, 2);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerModule();

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

    }


    /**
     * registerBinders function.
     *
     * @access private
     * @return void
     */
    private function registerBinders()
    {
        $this->app->bind(MemberInterface::class, function () {
            return new MemberCacheDecorator(new MemberRepository(new Member));
        });

        $this->app->bind(MemberActivityLogInterface::class, function () {
            return new MemberActivityLogCacheDecorator(new MemberActivityLogRepository(new MemberActivityLog));
        });
    }

    /**
     * @return bool
     */

    /**
     * setInAdmin function.
     *
     * @access public
     * @return bool
     */
    public function setInAdmin(): bool
    {
        return in_array(request()->segment(1), ['account', mconfig('base.config.admin_dir')]);
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
