<?php namespace Modules\WidgetGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Support\Traits\ModuleServiceProvider;

/**
 * WidgetGeneratorServiceProvider class.
 *
 * @extends ServiceProvider
 */
class WidgetGeneratorServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'WidgetGenerator';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'widgetgenerator';


    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        \Modules\WidgetGenerator\Console\Commands\WidgetCreateCommand::class => 'command.cms:widget:create',
        \Modules\WidgetGenerator\Console\Commands\WidgetRemoveCommand::class => 'command.cms:widget:remove'
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
