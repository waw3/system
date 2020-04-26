<?php

namespace Modules\Plugins\Captcha\Providers;

use Modules\Base\Traits\LoadAndPublishDataTrait;
use Modules\Plugins\Captcha\Facades\CaptchaFacade;
use Modules\Plugins\Captcha\Captcha;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(Captcha::class, function () {
            return new Captcha(
                setting('captcha_secret', config('modules.plugins.captcha.general.secret')),
                setting('captcha_site_key', config('modules.plugins.captcha.general.site_key')),
                config('modules.plugins.captcha.general.lang'),
                config('modules.plugins.captcha.general.attributes', [])
            );
        });
        AliasLoader::getInstance()->alias('Captcha', CaptchaFacade::class);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $this->app->make('validator')->extend('captcha', function ($attribute, $value) {
            unset($attribute);
            $ip = $this->app->make('request')->getClientIp();

            return $this->app->make(Captcha::class)->verify($value, $ip);
        });

        if ($this->app->bound('form')) {
            $this->app->make('form')->macro('captcha', function ($name = null, array $attributes = []) {
                return $this->app->make('botble::no-captcha')->display($name, $attributes);
            });
        }

        $this->setNamespace('modules.plugins.captcha')
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations();

        $this->app->register(HookServiceProvider::class);
    }
}
