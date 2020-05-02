<?php namespace Modules\Translation\Providers;

use Event;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Modules\Support\Traits\ModuleServiceProvider;
use Modules\Translation\Services\Manager;


/**
 * TranslationServiceProvider class.
 *
 * @extends ServiceProvider
 */
class TranslationServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Translation';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'translation';

    /**
     * The command mappings for the application.
     *
     * @var array
     */
    protected $commands = [
        \Modules\Translation\Console\Commands\ImportCommand::class => 'command.cms:translations:import',
        \Modules\Translation\Console\Commands\FindCommand::class => 'command.cms:translations:find'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        \Modules\Translation\Console\Commands\ResetCommand::class => 'command.cms:translations:reset',
        \Modules\Translation\Console\Commands\ExportCommand::class => 'command.cms:translations:export',
        \Modules\Translation\Console\Commands\CleanCommand::class => 'command.cms:translations:clean'
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
                'id'          => 'cms-plugin-translation',
                'priority'    => 6,
                'parent_id'   => 'cms-core-platform-administration',
                'name'        => 'modules.translation::translation.menu_name',
                'icon'        => null,
                'url'         => route('translations.index'),
                'permissions' => ['translations.index'],
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
        $this->app->bind('translation-manager', Manager::class);
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
