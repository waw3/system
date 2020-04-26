<?php namespace Modules\DevTool\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Support\Traits\ModuleServiceProvider;


/**
 * DevToolServiceProvider class.
 *
 * @extends ServiceProvider
 */
class DevToolServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'DevTool';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'devtool';

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
        RouteServiceProvider::class
    ];


    /**
     * The command mappings for the application.
     *
     * @var array
     */
    protected $commands = [
        //\Modules\DevTool\Console\Commands\COMMAND_NAME::class => 'command.name:sun'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        \Modules\DevTool\Console\Commands\InstallCommand::class => 'command.cms:install',
        \Modules\DevTool\Console\Commands\LocaleCreateCommand::class => 'command.cms:locale:create',
        \Modules\DevTool\Console\Commands\LocaleRemoveCommand::class => 'command.cms:locale:remove',
        \Modules\DevTool\Console\Commands\Make\ControllerMakeCommand::class => 'command.',
        \Modules\DevTool\Console\Commands\Make\FormMakeCommand::class => 'command.cms:make:form',
        \Modules\DevTool\Console\Commands\Make\ModelMakeCommand::class => 'command.cms:make:model',
        \Modules\DevTool\Console\Commands\Make\RepositoryMakeCommand::class => 'command.cms:make:repository',
        \Modules\DevTool\Console\Commands\Make\RequestMakeCommand::class => 'command.cms:make:request',
        \Modules\DevTool\Console\Commands\Make\RouteMakeCommand::class => 'command.cms:make:route',
        \Modules\DevTool\Console\Commands\Make\TableMakeCommand::class => 'command.cms:make:table',
        \Modules\DevTool\Console\Commands\PackageCreateCommand::class => 'command.cms:package:create',
        \Modules\DevTool\Console\Commands\RebuildPermissionsCommand::class => 'command.cms:user:rebuild-permissions',
        \Modules\DevTool\Console\Commands\TestSendMailCommand::class => 'command.cms:mail:test',
        \Modules\DevTool\Console\Commands\TruncateTablesCommand::class => 'command.cms:truncate:run',
        \Modules\DevTool\Console\Commands\PackageMakeCrudCommand::class => 'command.cms:package:make:crud',

        \Modules\DevTool\Console\Commands\GitCommitChecker\InstallHooks::class => 'command.git:install-hooks',
        \Modules\DevTool\Console\Commands\GitCommitChecker\PreCommitHook::class => 'command.git:create-phpcs',
        \Modules\DevTool\Console\Commands\GitCommitChecker\InstallPhpcs::class => 'command.git:pre-commit-hook'
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
        //
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootModule();
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
