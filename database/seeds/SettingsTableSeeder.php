<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'site_title',
                'value' => 'PHP platform based on Laravel Framework',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'copyright',
                'value' => '© 2016 Botble Technologies. All right reserved. Designed by <a href="http://nghiadev.com" target="_blank">Nghia Minh</a>',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'admin_email',
                'value' => 'admin@email.com',
            ),
            3 => 
            array (
                'id' => 6,
                'key' => 'seo_title',
                'value' => 'Botble Platform',
            ),
            4 => 
            array (
                'id' => 7,
                'key' => 'seo_description',
                'value' => 'Botble Platform - PHP platform base on Laravel Framework',
            ),
            5 => 
            array (
                'id' => 8,
                'key' => 'seo_keywords',
                'value' => 'botble, botble team, botble platform, php platform, php framework, web development',
            ),
            6 => 
            array (
                'id' => 9,
                'key' => 'contact_address',
                'value' => 'Elinext Building, 37 Phan Xich Long, ward 3, Phu Nhuan district, Ho Chi Minh, Vietnam',
            ),
            7 => 
            array (
                'id' => 10,
                'key' => 'contact_email',
                'value' => 'sangnguyenplus@gmail.com',
            ),
            8 => 
            array (
                'id' => 11,
                'key' => 'email_support',
                'value' => 'sangnguyenplus@gmail.com',
            ),
            9 => 
            array (
                'id' => 12,
                'key' => 'contact_phone',
                'value' => '+84988606928',
            ),
            10 => 
            array (
                'id' => 13,
                'key' => 'contact_hotline',
                'value' => '+84988606928',
            ),
            11 => 
            array (
                'id' => 14,
                'key' => 'enable_captcha',
                'value' => '0',
            ),
            12 => 
            array (
                'id' => 15,
                'key' => 'about',
                'value' => '<p>Content here</p>
',
            ),
            13 => 
            array (
                'id' => 16,
                'key' => 'show_admin_bar',
                'value' => '0',
            ),
            14 => 
            array (
                'id' => 17,
                'key' => 'theme',
                'value' => 'ripple',
            ),
            15 => 
            array (
                'id' => 18,
                'key' => 'enable_change_admin_theme',
                'value' => '1',
            ),
            16 => 
            array (
                'id' => 19,
                'key' => 'enable_multi_language_in_admin',
                'value' => '1',
            ),
            17 => 
            array (
                'id' => 20,
                'key' => 'enable_https',
                'value' => '0',
            ),
            18 => 
            array (
                'id' => 21,
                'key' => 'google_plus',
                'value' => 'https://plus.google.com',
            ),
            19 => 
            array (
                'id' => 22,
                'key' => 'facebook',
                'value' => 'https://www.facebook.com/botble.technologies',
            ),
            20 => 
            array (
                'id' => 23,
                'key' => 'twitter',
                'value' => 'https://twitter.com/botble',
            ),
            21 => 
            array (
                'id' => 24,
                'key' => 'enable_cache',
                'value' => '0',
            ),
            22 => 
            array (
                'id' => 25,
                'key' => 'cache_time',
                'value' => '10',
            ),
            23 => 
            array (
                'id' => 26,
                'key' => 'cache_time_site_map',
                'value' => '3600',
            ),
            24 => 
            array (
                'id' => 27,
                'key' => 'language_hide_default',
                'value' => '1',
            ),
            25 => 
            array (
                'id' => 28,
                'key' => 'language_switcher_display',
                'value' => 'dropdown',
            ),
            26 => 
            array (
                'id' => 29,
                'key' => 'language_display',
                'value' => 'all',
            ),
            27 => 
            array (
                'id' => 30,
                'key' => 'language_hide_languages',
                'value' => '[]',
            ),
            28 => 
            array (
                'id' => 31,
                'key' => 'theme-ripple-site_title',
                'value' => 'Botble Technologies',
            ),
            29 => 
            array (
                'id' => 34,
                'key' => 'theme-ripple-copyright',
                'value' => '© 2019 Botble Technologies. All right reserved. Designed by Nghia Minh.',
            ),
            30 => 
            array (
                'id' => 35,
                'key' => 'theme-newstv-copyright',
                'value' => '© Copyright 2017 Botble Technologies. All Rights Reserved.',
            ),
            31 => 
            array (
                'id' => 36,
                'key' => 'theme-newstv-theme_color',
                'value' => 'red',
            ),
            32 => 
            array (
                'id' => 38,
                'key' => 'theme-newstv-logo',
                'value' => 'https://s3-ap-southeast-1.amazonaws.com/botble/cms/logo/logo.png',
            ),
            33 => 
            array (
                'id' => 39,
                'key' => 'rich_editor',
                'value' => 'ckeditor',
            ),
            34 => 
            array (
                'id' => 41,
                'key' => 'admin_title',
                'value' => 'Botble Technologies',
            ),
            35 => 
            array (
                'id' => 44,
                'key' => 'activated_plugins',
                'value' => '["analytics","audit-log","backup","captcha","log-viewer","language","request-log","social-login","custom-field","member","contact","blog","gallery","comments","cookie-consent","translation","payment","maintenance-mode","impersonate","post-scheduler-master","block","product"]',
            ),
            36 => 
            array (
                'id' => 45,
                'key' => 'theme-ripple-vi-copyright',
                'value' => '© 2019 Botble Technologies. Tất cả quyền đã được bảo hộ. Thiết kế bởi Minh Nghĩa.',
            ),
            37 => 
            array (
                'id' => 47,
                'key' => 'theme-newstv-vi-copyright',
                'value' => '© 2017 Botble Technologies. Tất cả quyền đã được bảo hộ.',
            ),
            38 => 
            array (
                'id' => 48,
                'key' => 'theme-newstv-vi-theme_color',
                'value' => 'red',
            ),
            39 => 
            array (
                'id' => 49,
                'key' => 'theme-newstv-vi-top_banner',
                'value' => '/themes/newstv/assets/images/banner.png',
            ),
            40 => 
            array (
                'id' => 51,
                'key' => 'time_zone',
                'value' => 'America/Detroit',
            ),
            41 => 
            array (
                'id' => 52,
                'key' => 'optimize_page_speed_enable',
                'value' => '0',
            ),
            42 => 
            array (
                'id' => 53,
                'key' => 'enable_send_error_reporting_via_email',
                'value' => '1',
            ),
            43 => 
            array (
                'id' => 54,
                'key' => 'default_admin_theme',
                'value' => 'darkblue',
            ),
            44 => 
            array (
                'id' => 55,
                'key' => 'cache_admin_menu_enable',
                'value' => '1',
            ),
            45 => 
            array (
                'id' => 56,
                'key' => 'language_show_default_item_if_current_version_not_existed',
                'value' => '1',
            ),
            46 => 
            array (
                'id' => 57,
                'key' => 'show_site_name',
                'value' => '0',
            ),
            47 => 
            array (
                'id' => 62,
                'key' => 'captcha_site_key',
                'value' => 'no-captcha-site-key',
            ),
            48 => 
            array (
                'id' => 63,
                'key' => 'captcha_secret',
                'value' => 'no-captcha-secret',
            ),
            49 => 
            array (
                'id' => 64,
                'key' => 'social_utilities_enable',
                'value' => '1',
            ),
            50 => 
            array (
                'id' => 85,
                'key' => 'submit',
                'value' => 'save',
            ),
            51 => 
            array (
                'id' => 106,
                'key' => 'social_utilities_facebook_url',
                'value' => 'botble.technologies',
            ),
            52 => 
            array (
                'id' => 107,
                'key' => 'social_utilities_twitter_url',
                'value' => 'sangnguyen2603',
            ),
            53 => 
            array (
                'id' => 108,
                'key' => 'social_utilities_google-plus_url',
                'value' => 'sangnguyen2603',
            ),
            54 => 
            array (
                'id' => 109,
                'key' => 'social_utilities_linkedin_url',
                'value' => 'sangnguyen2603',
            ),
            55 => 
            array (
                'id' => 110,
                'key' => 'social_utilities_pinterest_url',
                'value' => 'sangnguyen2603',
            ),
            56 => 
            array (
                'id' => 111,
                'key' => 'theme-ripple-show_site_name',
                'value' => '0',
            ),
            57 => 
            array (
                'id' => 112,
                'key' => 'theme-ripple-seo_title',
                'value' => 'Botble Technologies',
            ),
            58 => 
            array (
                'id' => 113,
                'key' => 'theme-ripple-seo_description',
                'value' => 'Botble Platform - PHP platform base on Laravel Framework',
            ),
            59 => 
            array (
                'id' => 118,
                'key' => 'theme-ripple-primary_font',
                'value' => 'Poppins',
            ),
            60 => 
            array (
                'id' => 120,
                'key' => 'theme-ripple-vi-site_title',
                'value' => 'PHP platform based on Laravel Framework',
            ),
            61 => 
            array (
                'id' => 121,
                'key' => 'theme-ripple-vi-show_site_name',
                'value' => '0',
            ),
            62 => 
            array (
                'id' => 122,
                'key' => 'theme-ripple-vi-seo_title',
                'value' => 'Botble Technologies',
            ),
            63 => 
            array (
                'id' => 124,
                'key' => 'theme-ripple-vi-primary_font',
                'value' => 'Roboto',
            ),
            64 => 
            array (
                'id' => 126,
                'key' => 'theme-ripple-vi-seo_description',
                'value' => 'PHP platform based on Laravel Framework',
            ),
            65 => 
            array (
                'id' => 138,
                'key' => 'theme-newstv-site_title',
                'value' => 'Botble Technologies',
            ),
            66 => 
            array (
                'id' => 139,
                'key' => 'theme-newstv-show_site_name',
                'value' => '0',
            ),
            67 => 
            array (
                'id' => 140,
                'key' => 'theme-newstv-seo_title',
                'value' => 'Botble Technologies',
            ),
            68 => 
            array (
                'id' => 142,
                'key' => 'theme-newstv-top_banner',
                'value' => 'ads/728x90.jpg',
            ),
            69 => 
            array (
                'id' => 143,
                'key' => 'theme-ripple-site_description',
                'value' => 'A young team in Vietnam',
            ),
            70 => 
            array (
                'id' => 144,
                'key' => 'theme-ripple-address',
                'value' => 'Go Vap District, HCM City, Vietnam',
            ),
            71 => 
            array (
                'id' => 145,
                'key' => 'theme-ripple-website',
                'value' => 'https://botble.com',
            ),
            72 => 
            array (
                'id' => 146,
                'key' => 'theme-ripple-contact_email',
                'value' => 'botble.cms@gmail.com',
            ),
            73 => 
            array (
                'id' => 151,
                'key' => 'theme-ripple-vi-site_description',
                'value' => 'Một nhóm trẻ tại Việt Nam',
            ),
            74 => 
            array (
                'id' => 152,
                'key' => 'theme-ripple-vi-address',
                'value' => 'Quận Gò Vấp, TP. Hồ Chí Minh, Việt Nam',
            ),
            75 => 
            array (
                'id' => 153,
                'key' => 'theme-ripple-vi-website',
                'value' => 'https://botble.com',
            ),
            76 => 
            array (
                'id' => 154,
                'key' => 'theme-ripple-vi-contact_email',
                'value' => 'botble.cms@gmail.com',
            ),
            77 => 
            array (
                'id' => 159,
                'key' => 'membership_authorization_at',
                'value' => '2020-04-22 23:15:52',
            ),
            78 => 
            array (
                'id' => 160,
                'key' => 'theme-ripple-favicon',
                'value' => 'logo/logo.png',
            ),
            79 => 
            array (
                'id' => 161,
                'key' => 'theme-ripple-logo',
                'value' => '',
            ),
            80 => 
            array (
                'id' => 162,
                'key' => 'theme-ripple-facebook',
                'value' => '',
            ),
            81 => 
            array (
                'id' => 163,
                'key' => 'theme-ripple-twitter',
                'value' => '',
            ),
            82 => 
            array (
                'id' => 164,
                'key' => 'theme-ripple-youtube',
                'value' => '',
            ),
            83 => 
            array (
                'id' => 168,
                'key' => 'cookie_consent_enable',
                'value' => '1',
            ),
            84 => 
            array (
                'id' => 175,
                'key' => 'theme-ripple-cookie_consent_message',
                'value' => 'Your experience on this site will be improved by allowing cookies.',
            ),
            85 => 
            array (
                'id' => 176,
                'key' => 'theme-ripple-cookie_consent_button_text',
                'value' => 'Allow cookies',
            ),
            86 => 
            array (
                'id' => 186,
                'key' => 'email_driver',
                'value' => 'smtp',
            ),
            87 => 
            array (
                'id' => 187,
                'key' => 'email_port',
                'value' => '2525',
            ),
            88 => 
            array (
                'id' => 188,
                'key' => 'email_host',
                'value' => 'smtp.mailtrap.io',
            ),
            89 => 
            array (
                'id' => 193,
                'key' => 'email_encryption',
                'value' => 'tls',
            ),
            90 => 
            array (
                'id' => 195,
                'key' => 'email_from_name',
                'value' => 'BMS',
            ),
            91 => 
            array (
                'id' => 197,
                'key' => 'plugins_contact_notice_status',
                'value' => '1',
            ),
            92 => 
            array (
                'id' => 198,
                'key' => 'payment_stripe_name',
                'value' => 'Pay online via Stripe',
            ),
            93 => 
            array (
                'id' => 199,
                'key' => 'payment_stripe_client_id',
                'value' => 'admin',
            ),
            94 => 
            array (
                'id' => 200,
                'key' => 'payment_stripe_secret',
                'value' => 'password',
            ),
            95 => 
            array (
                'id' => 201,
                'key' => 'payment_stripe_status',
                'value' => '1',
            ),
            96 => 
            array (
                'id' => 202,
                'key' => 'payment_paypal_name',
                'value' => 'Pay online via PayPal',
            ),
            97 => 
            array (
                'id' => 203,
                'key' => 'payment_paypal_client_id',
                'value' => 'admin',
            ),
            98 => 
            array (
                'id' => 204,
                'key' => 'payment_paypal_client_secret',
                'value' => 'password',
            ),
            99 => 
            array (
                'id' => 205,
                'key' => 'payment_paypal_mode',
                'value' => '0',
            ),
            100 => 
            array (
                'id' => 206,
                'key' => 'payment_paypal_status',
                'value' => '1',
            ),
            101 => 
            array (
                'id' => 207,
                'key' => 'social_login_enable',
                'value' => '1',
            ),
            102 => 
            array (
                'id' => 208,
                'key' => 'social_login_facebook_enable',
                'value' => '0',
            ),
            103 => 
            array (
                'id' => 209,
                'key' => 'social_login_facebook_app_id',
                'value' => 'admin',
            ),
            104 => 
            array (
                'id' => 210,
                'key' => 'social_login_facebook_app_secret',
                'value' => 'password',
            ),
            105 => 
            array (
                'id' => 211,
                'key' => 'social_login_google_enable',
                'value' => '0',
            ),
            106 => 
            array (
                'id' => 214,
                'key' => 'social_login_github_enable',
                'value' => '0',
            ),
            107 => 
            array (
                'id' => 217,
                'key' => 'social_login_linkedin_enable',
                'value' => '0',
            ),
        ));

        
    }
}