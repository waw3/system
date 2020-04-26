<?php namespace Modules\Slug\Providers;

use Modules\Support\Traits\ModuleServiceProvider;
use Modules\Slug\Models\Slug;
use Modules\Slug\Repositories\Caches\SlugCacheDecorator;
use Modules\Slug\Repositories\Eloquent\SlugRepository;
use Modules\Slug\Repositories\Interfaces\SlugInterface;
use Illuminate\Support\ServiceProvider;

/**
 * SlugServiceProvider class.
 *
 * @extends ServiceProvider
 */
class SlugServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Slug';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'slug';

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Modules\Base\Events\UpdatedContentEvent::class => [
            \Modules\Slug\Listeners\UpdatedContentListener::class,
        ],
        \Modules\Base\Events\CreatedContentEvent::class => [
            \Modules\Slug\Listeners\CreatedContentListener::class,
        ],
        \Modules\Base\Events\DeletedContentEvent::class => [
            \Modules\Slug\Listeners\DeletedContentListener::class,
        ],
    ];

    /**
     * The command mappings for the application.
     * \PATH\TO\COMMAND::class => 'command.name',
     * @var array
     */
    protected $commandsInConsoleOnly = [
        \Modules\Slug\Console\Commands\ChangeSlugPrefixCommand::class => 'command.cms:slug:prefix'
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
        $this->app->bind(SlugInterface::class, function () {
            return new SlugCacheDecorator(new SlugRepository(new Slug));
        });
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
