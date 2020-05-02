<?php

use Illuminate\Database\Seeder;

class SlugsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('slugs')->delete();
        
        DB::table('slugs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => '13000-people-have-bought-our-theme',
                'reference_id' => 4,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'top-search-engine-optimization-strategies',
                'reference_id' => 5,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'which-company-would-you-choose',
                'reference_id' => 6,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'used-car-dealer-sales-tricks-exposed',
                'reference_id' => 7,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            4 => 
            array (
                'id' => 5,
                'key' => '20-ways-to-sell-your-product-faster',
                'reference_id' => 8,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'the-secrets-of-rich-and-famous-writers',
                'reference_id' => 9,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            6 => 
            array (
                'id' => 7,
                'key' => 'imagine-losing-20-pounds-in-14-days',
                'reference_id' => 10,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            7 => 
            array (
                'id' => 8,
                'key' => 'are-you-still-using-that-slow-old-typewriter',
                'reference_id' => 11,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            8 => 
            array (
                'id' => 9,
                'key' => 'a-skin-cream-thats-proven-to-work',
                'reference_id' => 12,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            9 => 
            array (
                'id' => 10,
                'key' => '10-reasons-to-start-your-own-profitable-website',
                'reference_id' => 13,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            10 => 
            array (
                'id' => 11,
                'key' => 'simple-ways-to-reduce',
                'reference_id' => 14,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            11 => 
            array (
                'id' => 12,
                'key' => 'apple-imac-with-retina-5k-display-review',
                'reference_id' => 15,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            12 => 
            array (
                'id' => 13,
                'key' => '10-reasons-to-start-your-own-profitable-website-1',
                'reference_id' => 16,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            13 => 
            array (
                'id' => 14,
                'key' => 'unlock-the-secrets-of-selling-high-ticket-items',
                'reference_id' => 17,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            14 => 
            array (
                'id' => 15,
                'key' => '10000-web-site-visitors-in-one-monthguaranteed',
                'reference_id' => 18,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            15 => 
            array (
                'id' => 16,
                'key' => 'are-you-still-using-that-slow-old-typewriter-1',
                'reference_id' => 19,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            16 => 
            array (
                'id' => 17,
                'key' => 'a-skin-cream-thats-proven-to-work-1',
                'reference_id' => 20,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            17 => 
            array (
                'id' => 18,
                'key' => 'top-search-engine-optimization-strategies-1',
                'reference_id' => 21,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            18 => 
            array (
                'id' => 21,
                'key' => '10000-web-site-visitors-in-one-monthguaranteed-1',
                'reference_id' => 46,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2020-04-06 21:25:08',
                'prefix' => '',
            ),
            19 => 
            array (
                'id' => 23,
                'key' => 'uncategorized',
                'reference_id' => 1,
                'reference_type' => 'Modules\\Blog\\Models\\Category',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            20 => 
            array (
                'id' => 24,
                'key' => 'events',
                'reference_id' => 6,
                'reference_type' => 'Modules\\Blog\\Models\\Category',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            21 => 
            array (
                'id' => 25,
                'key' => 'projects',
                'reference_id' => 7,
                'reference_type' => 'Modules\\Blog\\Models\\Category',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            22 => 
            array (
                'id' => 26,
                'key' => 'portfolio',
                'reference_id' => 8,
                'reference_type' => 'Modules\\Blog\\Models\\Category',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            23 => 
            array (
                'id' => 27,
                'key' => 'business',
                'reference_id' => 9,
                'reference_type' => 'Modules\\Blog\\Models\\Category',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            24 => 
            array (
                'id' => 28,
                'key' => 'resources',
                'reference_id' => 10,
                'reference_type' => 'Modules\\Blog\\Models\\Category',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            25 => 
            array (
                'id' => 29,
                'key' => 'new-update',
                'reference_id' => 11,
                'reference_type' => 'Modules\\Blog\\Models\\Category',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            26 => 
            array (
                'id' => 30,
                'key' => 'botble',
                'reference_id' => 5,
                'reference_type' => 'Modules\\Blog\\Models\\Tag',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2019-10-26 13:52:18',
                'prefix' => 'tag',
            ),
            27 => 
            array (
                'id' => 31,
                'key' => 'botble-cms',
                'reference_id' => 6,
                'reference_type' => 'Modules\\Blog\\Models\\Tag',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2019-10-26 13:52:18',
                'prefix' => 'tag',
            ),
            28 => 
            array (
                'id' => 32,
                'key' => 'contact',
                'reference_id' => 1,
                'reference_type' => 'Modules\\Page\\Models\\Page',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2017-11-30 13:26:09',
                'prefix' => '',
            ),
            29 => 
            array (
                'id' => 34,
                'key' => 'photography',
                'reference_id' => 1,
                'reference_type' => 'Modules\\Plugins\\Gallery\\Models\\Gallery',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2019-10-26 13:56:54',
                'prefix' => 'gallery',
            ),
            30 => 
            array (
                'id' => 35,
                'key' => 'selfie',
                'reference_id' => 2,
                'reference_type' => 'Modules\\Plugins\\Gallery\\Models\\Gallery',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2019-10-26 13:56:54',
                'prefix' => 'gallery',
            ),
            31 => 
            array (
                'id' => 36,
                'key' => 'new-day',
                'reference_id' => 3,
                'reference_type' => 'Modules\\Plugins\\Gallery\\Models\\Gallery',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2019-10-26 13:56:54',
                'prefix' => 'gallery',
            ),
            32 => 
            array (
                'id' => 37,
                'key' => 'morning',
                'reference_id' => 4,
                'reference_type' => 'Modules\\Plugins\\Gallery\\Models\\Gallery',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2019-10-26 13:56:54',
                'prefix' => 'gallery',
            ),
            33 => 
            array (
                'id' => 38,
                'key' => 'happy-day',
                'reference_id' => 5,
                'reference_type' => 'Modules\\Plugins\\Gallery\\Models\\Gallery',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2019-10-26 13:56:54',
                'prefix' => 'gallery',
            ),
            34 => 
            array (
                'id' => 39,
                'key' => 'perfect',
                'reference_id' => 6,
                'reference_type' => 'Modules\\Plugins\\Gallery\\Models\\Gallery',
                'created_at' => '2017-11-30 13:26:09',
                'updated_at' => '2019-10-26 13:56:54',
                'prefix' => 'gallery',
            ),
            35 => 
            array (
                'id' => 40,
                'key' => 'chua-phan-loai',
                'reference_id' => 12,
                'reference_type' => 'Modules\\Blog\\Models\\Category',
                'created_at' => '2018-04-13 05:02:12',
                'updated_at' => '2018-04-13 05:02:12',
                'prefix' => '',
            ),
            36 => 
            array (
                'id' => 48,
                'key' => 'simple-ways-to-reduce-1',
                'reference_id' => 49,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2018-04-13 05:41:28',
                'updated_at' => '2020-04-06 21:27:07',
                'prefix' => '',
            ),
            37 => 
            array (
                'id' => 51,
                'key' => 'xay-dung-website-mot-cach-nhanh-chong-1',
                'reference_id' => 8,
                'reference_type' => 'Modules\\Blog\\Models\\Tag',
                'created_at' => '2018-04-13 05:42:20',
                'updated_at' => '2019-10-26 13:52:18',
                'prefix' => 'tag',
            ),
            38 => 
            array (
                'id' => 52,
                'key' => 'xay-dung-website-mot-cach-nhanh-chong-2',
                'reference_id' => 9,
                'reference_type' => 'Modules\\Blog\\Models\\Tag',
                'created_at' => '2018-04-13 05:42:20',
                'updated_at' => '2019-10-26 13:52:18',
                'prefix' => 'tag',
            ),
            39 => 
            array (
                'id' => 53,
                'key' => 'unlock-the-secrets-of-selling-high-ticket-items-1',
                'reference_id' => 51,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2018-04-13 05:43:09',
                'updated_at' => '2020-04-06 21:25:59',
                'prefix' => '',
            ),
            40 => 
            array (
                'id' => 54,
                'key' => 'san-pham-tri-tue-viet-nam-1',
                'reference_id' => 10,
                'reference_type' => 'Modules\\Blog\\Models\\Tag',
                'created_at' => '2018-04-13 05:43:09',
                'updated_at' => '2019-10-26 13:52:18',
                'prefix' => 'tag',
            ),
            41 => 
            array (
                'id' => 59,
                'key' => 'popular',
                'reference_id' => 25,
                'reference_type' => 'Modules\\Blog\\Models\\Tag',
                'created_at' => '2018-04-13 06:00:35',
                'updated_at' => '2019-10-26 13:52:18',
                'prefix' => 'tag',
            ),
            42 => 
            array (
                'id' => 61,
                'key' => 'hanh-trinh-tim-kiem-su-khac-biet',
                'reference_id' => 53,
                'reference_type' => 'Modules\\Blog\\Models\\Post',
                'created_at' => '2018-04-13 06:02:59',
                'updated_at' => '2018-04-13 06:02:59',
                'prefix' => '',
            ),
            43 => 
            array (
                'id' => 70,
                'key' => 'test',
                'reference_id' => 18,
                'reference_type' => 'Modules\\Page\\Models\\Page',
                'created_at' => '2020-04-23 08:48:12',
                'updated_at' => '2020-04-23 08:48:12',
                'prefix' => '',
            ),
        ));

        
    }
}