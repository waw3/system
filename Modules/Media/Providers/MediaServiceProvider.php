<?php namespace Modules\Media\Providers;

use Modules\Base\Supports\Helper;
use Modules\Media\Facades\RvMediaFacade;
use Modules\Media\Models\MediaFile;
use Modules\Media\Models\MediaFolder;
use Modules\Media\Models\MediaSetting;
use Modules\Media\Repositories\Caches\MediaFileCacheDecorator;
use Modules\Media\Repositories\Caches\MediaFolderCacheDecorator;
use Modules\Media\Repositories\Caches\MediaSettingCacheDecorator;
use Modules\Media\Repositories\Eloquent\MediaFileRepository;
use Modules\Media\Repositories\Eloquent\MediaFolderRepository;
use Modules\Media\Repositories\Eloquent\MediaSettingRepository;
use Modules\Media\Repositories\Interfaces\MediaFileInterface;
use Modules\Media\Repositories\Interfaces\MediaFolderInterface;
use Modules\Media\Repositories\Interfaces\MediaSettingInterface;
use Event;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Modules\Support\Traits\ModuleServiceProvider;

/**
 * MediaServiceProvider class.
 *
 * @extends ServiceProvider
 */
class MediaServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Media';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'media';

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
        \Modules\Media\Console\Commands\GenerateThumbnailCommand::class => 'cms:media:thumbnail:delete',
        \Modules\Media\Console\Commands\DeleteThumbnailCommand::class  =>  'cms:media:thumbnail:generate'
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
                'id'          => 'cms-core-media',
                'priority'    => 995,
                'parent_id'   => null,
                'name'        => 'modules.media::media.menu_name',
                'icon'        => 'far fa-images',
                'url'         => route('media.index'),
                'permissions' => ['media.index'],
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
        $this->app->bind(MediaFileInterface::class, function () {
            return new MediaFileCacheDecorator(
                new MediaFileRepository(new MediaFile),
                'Modules\Media\Repositories'
            );
        });

        $this->app->bind(MediaFolderInterface::class, function () {
            return new MediaFolderCacheDecorator(
                new MediaFolderRepository(new MediaFolder),
                'Modules\Media\Repositories'
            );
        });

        $this->app->bind(MediaSettingInterface::class, function () {
            return new MediaSettingCacheDecorator(
                new MediaSettingRepository(new MediaSetting)
            );
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
