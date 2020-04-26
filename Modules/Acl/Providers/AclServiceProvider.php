<?php namespace Modules\Acl\Providers;

use Event, Exception;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Router;
use Modules\Acl\Models\Activation;
use Modules\Acl\Models\Role;
use Modules\Acl\Models\User;
use Modules\Acl\Repositories\Caches\RoleCacheDecorator;
use Modules\Acl\Repositories\Eloquent\ActivationRepository;
use Modules\Acl\Repositories\Eloquent\RoleRepository;
use Modules\Acl\Repositories\Eloquent\UserRepository;
use Modules\Acl\Repositories\Interfaces\ActivationInterface;
use Modules\Acl\Repositories\Interfaces\RoleInterface;
use Modules\Acl\Repositories\Interfaces\UserInterface;
use Modules\Base\Supports\Helper;
use Modules\Support\Traits\ModuleServiceProvider;

/**
 * AclServiceProvider class.
 *
 * @extends ServiceProvider
 */
class AclServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Acl';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'acl';

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
     * providers
     *
     * @var mixed
     * @access protected
     */
    protected $providers = [
        //
    ];

    /**
     * Register the composer classes.
     *
     * @var array
     */
    protected $composerViews = [
       //'backend.includes.sidebar' => \Modules\Acl\Http\Composers\Backend\Composer::class
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
        //
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
        //\Modules\Acl\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        \Modules\Acl\Console\Commands\UserCreateCommand::class => 'command.cms:user:create'
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
        'auth' => \Modules\Acl\Http\Middleware\Authenticate::class,
        'guest' => \Modules\Acl\Http\Middleware\RedirectIfAuthenticated::class
    ];


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootModule();

        config(['auth.providers.users.model' => User::class]);

        $this->garbageCollect();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-core-role-permission',
                    'priority'    => 2,
                    'parent_id'   => 'cms-core-platform-administration',
                    'name'        => 'modules.acl::permissions.role_permission',
                    'icon'        => null,
                    'url'         => route('roles.index'),
                    'permissions' => ['roles.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-core-user',
                    'priority'    => 3,
                    'parent_id'   => 'cms-core-platform-administration',
                    'name'        => 'modules.acl::users.users',
                    'icon'        => null,
                    'url'         => route('users.index'),
                    'permissions' => ['users.index'],
                ]);
        });
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

        $this->app->bind(UserInterface::class, function () {
            return new UserRepository(new User);
        });

        $this->app->bind(ActivationInterface::class, function () {
            return new ActivationRepository(new Activation);
        });

        $this->app->bind(RoleInterface::class, function () {
            return new RoleCacheDecorator(new RoleRepository(new Role));
        });
    }

    /**
     * Garbage collect activations and reminders.
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function garbageCollect()
    {
        $this->sweep($this->app->make(ActivationInterface::class), mconfig('acl.config.activations.lottery'));
    }

    /**
     * Sweep expired codes.
     *
     * @param mixed $repository
     * @param array $lottery
     * @return void
     */
    protected function sweep($repository, array $lottery)
    {
        if ($this->configHitsLottery($lottery)) {
            try {
                $repository->removeExpired();
            } catch (Exception $exception) {
                info($exception->getMessage());
            }
        }
    }

    /**
     * Determine if the configuration odds hit the lottery.
     *
     * @param array $lottery
     * @return bool
     */
    protected function configHitsLottery(array $lottery)
    {
        return mt_rand(1, $lottery[1]) <= $lottery[0];
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
