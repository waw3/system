<?php namespace Modules\Mailbox\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
//use BeyondCode\Mailbox\Facades\Mailbox;
use Modules\Mailbox\Services\Inbox;
use Modules\Mailbox\Models\InboxEmail;
use Modules\Support\Traits\ModuleServiceProvider;

/**
 * MailboxServiceProvider class.
 *
 * @extends ServiceProvider
 */
class MailboxServiceProvider extends ServiceProvider
{
    use ModuleServiceProvider;

	/**
     * @var string $moduleName
     */
    protected $moduleName = 'Mailbox';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'mailbox';

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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootModule();

        //Mailbox::catchAll(Inbox::class);

        $this->globalVariables();
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
        $this->app->bind('Inbox', function ($app) {
            return new Inbox();
        });
    }

    /**
     * Register Inbox routes.
     *
     * @return void
     */
    protected function globalVariables()
    {
        try {
            $emailCount = InboxEmail::where('read', '!=', 1)->orWhereNull('read')->count();
        } catch (\Throwable $th) {
            $emailCount = 0;
        }


        View::share('emailCount', $emailCount);
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
