<?php namespace Modules\Block\Providers;

use Event, Language, CustomField;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Modules\Support\Traits\ModuleServiceProvider;
use Modules\Block\Models\Block;
use Modules\Block\Repositories\Caches\BlockCacheDecorator;
use Modules\Block\Repositories\Eloquent\BlockRepository;
use Modules\Block\Repositories\Interfaces\BlockInterface;
use Modules\Base\Supports\Helper;

/**
 * BlockServiceProvider class.
 *
 * @extends ServiceProvider
 */
class BlockServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Block';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'block';

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
                'id'          => 'cms-plugins-block',
                'priority'    => 6,
                'parent_id'   => null,
                'name'        => 'modules.block::block.menu',
                'icon'        => 'fa fa-code',
                'url'         => route('block.index'),
                'permissions' => ['block.index'],
            ]);
        });

        $this->app->booted(function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule([Block::class]);
            }

            if (defined('CUSTOM_FIELD_MODULE_SCREEN_NAME')) {
                CustomField::registerModule(Block::class)
                    ->registerRule('basic', trans('modules.block::block.name'), Block::class, function () {
                        return $this->app->make(BlockInterface::class)->pluck('blocks.name', 'blocks.id');
                    })
                    ->expandRule('other', 'Model', 'model_name', function () {
                        return [
                            Block::class => trans('modules.block::block.name'),
                        ];
                    });
            }
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
        $this->app->bind(BlockInterface::class, function () {
            return new BlockCacheDecorator(new BlockRepository(new Block));
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
