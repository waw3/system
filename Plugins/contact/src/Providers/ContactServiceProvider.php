<?php

namespace Modules\Plugins\Contact\Providers;

use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Supports\Helper;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Modules\Plugins\Contact\Models\ContactReply;
use Modules\Plugins\Contact\Repositories\Caches\ContactReplyCacheDecorator;
use Modules\Plugins\Contact\Repositories\Eloquent\ContactReplyRepository;
use Modules\Plugins\Contact\Repositories\Interfaces\ContactInterface;
use Modules\Plugins\Contact\Models\Contact;
use Modules\Plugins\Contact\Repositories\Caches\ContactCacheDecorator;
use Modules\Plugins\Contact\Repositories\Eloquent\ContactRepository;
use Modules\Plugins\Contact\Repositories\Interfaces\ContactReplyInterface;
use Event;
use Illuminate\Support\ServiceProvider;
use MailVariable;

class ContactServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(ContactInterface::class, function () {
            return new ContactCacheDecorator(new ContactRepository(new Contact));
        });

        $this->app->bind(ContactReplyInterface::class, function () {
            return new ContactReplyCacheDecorator(new ContactReplyRepository(new ContactReply));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('modules.plugins.contact')
            ->loadAndPublishConfigurations(['permissions', 'email'])
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-contact',
                'priority'    => 120,
                'parent_id'   => null,
                'name'        => 'modules.plugins.contact::contact.menu',
                'icon'        => 'far fa-envelope',
                'url'         => route('contacts.index'),
                'permissions' => ['contacts.index'],
            ]);
        });

        MailVariable::setModule(CONTACT_MODULE_SCREEN_NAME)
            ->addVariables([
                'contact_name'    => __('Contact name'),
                'contact_subject' => __('Contact subject'),
                'contact_email'   => __('Contact email'),
                'contact_phone'   => __('Contact phone'),
                'contact_address' => __('Contact address'),
                'contact_content' => __('Contact content'),
            ]);
    }
}
