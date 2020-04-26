<?php namespace Modules\ThemeGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Support\Traits\ModuleServiceProvider;

/**
 * ThemeGeneratorServiceProvider class.
 *
 * @extends ServiceProvider
 */
class ThemeGeneratorServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'ThemeGenerator';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'themegenerator';

    /**
     * The command mappings for the application.
     *
     * @var array
     */
    protected $commands = [
        \Modules\ThemeGenerator\Console\Commands\ThemeInstallSampleDataCommand::class => 'command.cms:theme:install-sample-data'
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        \Modules\ThemeGenerator\Console\Commands\ThemeCreateCommand::class => 'command.cms:theme:create'
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
