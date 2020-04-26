<?php

namespace Modules\Plugins\Analytics\Providers;

use Modules\Plugins\Analytics\Analytics;
use Modules\Plugins\Analytics\AnalyticsClient;
use Modules\Plugins\Analytics\AnalyticsClientFactory;
use Modules\Plugins\Analytics\Facades\AnalyticsFacade;
use Modules\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Modules\Plugins\Analytics\Exceptions\InvalidConfiguration;

class AnalyticsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(AnalyticsClient::class, function () {
            return AnalyticsClientFactory::createForConfig(config('modules.plugins.analytics.general'));
        });

        $this->app->bind(Analytics::class, function () {
            if (empty(setting('analytics_view_id', config('modules.plugins.analytics.general.view_id')))) {
                throw InvalidConfiguration::viewIdNotSpecified();
            }

            if (!setting('analytics_service_account_credentials')) {
                throw InvalidConfiguration::credentialsIsNotValid();
            }

            return new Analytics(
                $this->app->make(AnalyticsClient::class),
                setting('analytics_view_id', config('modules.plugins.analytics.general.view_id'))
            );
        });

        AliasLoader::getInstance()->alias('Analytics', AnalyticsFacade::class);
    }

    public function boot()
    {
        $this->setNamespace('modules.plugins.analytics')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);
    }
}
