<?php

namespace Modules\Plugins\CookieConsent\Providers;

use Modules\Base\Traits\LoadAndPublishDataTrait;
use Cookie;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Throwable;

class CookieConsentServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot()
    {
        $this->setNamespace('modules.plugins.cookie-consent')
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        $this->app->resolving(EncryptCookies::class, function (EncryptCookies $encryptCookies) {
            $encryptCookies->disableFor(config('modules.plugins.cookie-consent.general.cookie_name'));
        });

        $this->app['view']->composer('modules.plugins.cookie-consent::index', function (View $view) {
            $cookieConsentConfig = config('modules.plugins.cookie-consent.general');

            $alreadyConsentedWithCookies = Cookie::has($cookieConsentConfig['cookie_name']);

            $view->with(compact('alreadyConsentedWithCookies', 'cookieConsentConfig'));
        });

        if (defined('THEME_FRONT_FOOTER') && setting('cookie_consent_enable', false)) {
            add_filter(THEME_FRONT_FOOTER, [$this, 'registerCookieConsent'], 1346);
        }

        add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSettings'], 37, 1);

        theme_option()
            ->setSection([
                'title'      => __('Cookie Consent'),
                'desc'       => __('Cookie consent settings'),
                'id'         => 'opt-text-subsection-cookie-consent',
                'subsection' => true,
                'icon'       => 'fas fa-cookie-bite',
                'priority'   => 9999,
                'fields'     => [
                    [
                        'id'         => 'cookie_consent_message',
                        'type'       => 'text',
                        'label'      => __('Message'),
                        'attributes' => [
                            'name'    => 'cookie_consent_message',
                            'value'   => 'Your experience on this site will be improved by allowing cookies.',
                            'options' => [
                                'class'        => 'form-control',
                                'placeholder'  => __('Message'),
                                'data-counter' => 400,
                            ],
                        ],
                    ],

                    [
                        'id'         => 'cookie_consent_button_text',
                        'type'       => 'text',
                        'label'      => __('Button text'),
                        'attributes' => [
                            'name'    => 'cookie_consent_button_text',
                            'value'   => 'Allow cookies',
                            'options' => [
                                'class'        => 'form-control',
                                'placeholder'  => __('Button text'),
                                'data-counter' => 120,
                            ],
                        ],
                    ],
                ],
            ]);
    }

    /**
     * @param string $html
     * @return string
     * @throws \Throwable
     */
    public function registerCookieConsent($html)
    {
        return $html . view('modules.plugins.cookie-consent::index')->render();
    }

    /**
     * @param null $data
     * @return string
     * @throws Throwable
     */
    public function addSettings($data = null)
    {
        return $data . view('modules.plugins.cookie-consent::settings')->render();
    }
}
