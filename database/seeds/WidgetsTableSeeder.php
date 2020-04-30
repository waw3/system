<?php

use Illuminate\Database\Seeder;

class WidgetsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('widgets')->delete();
        
        DB::table('widgets')->insert(array (
            0 => 
            array (
                'id' => 2,
                'widget_id' => 'Modules\\Widget\\Widgets\\Text',
                'sidebar_id' => 'second_sidebar',
                'theme' => 'demo',
                'position' => 0,
                'data' => '{"id":"Modules\\\\Widget\\\\Widgets\\\\Text","name":"Text","content":""}',
                'created_at' => '2016-12-17 23:47:20',
                'updated_at' => '2016-12-17 23:47:20',
            ),
            1 => 
            array (
                'id' => 7,
                'widget_id' => 'RecentPostsWidget',
                'sidebar_id' => 'top_sidebar',
                'theme' => 'ripple',
                'position' => 0,
                'data' => '{"id":"RecentPostsWidget","name":"Recent Posts","number_display":"5"}',
                'created_at' => '2016-12-17 23:48:00',
                'updated_at' => '2016-12-17 23:48:00',
            ),
            2 => 
            array (
                'id' => 9,
                'widget_id' => 'Modules\\Widget\\Widgets\\Text',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'demo',
                'position' => 0,
                'data' => '{"id":"Modules\\\\Widget\\\\Widgets\\\\Text","name":"Text","content":""}',
                'created_at' => '2016-12-17 23:50:57',
                'updated_at' => '2016-12-17 23:50:57',
            ),
            3 => 
            array (
                'id' => 19,
                'widget_id' => 'TagsWidget',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'ripple',
                'position' => 0,
                'data' => '{"id":"TagsWidget","name":"Tags","number_display":"5"}',
                'created_at' => '2016-12-24 02:41:57',
                'updated_at' => '2016-12-24 02:41:57',
            ),
            4 => 
            array (
                'id' => 20,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'ripple',
                'position' => 1,
                'data' => '{"id":"CustomMenuWidget","name":"Categories","menu_id":"featured-categories"}',
                'created_at' => '2016-12-24 02:41:57',
                'updated_at' => '2016-12-24 02:41:57',
            ),
            5 => 
            array (
                'id' => 21,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'ripple',
                'position' => 2,
                'data' => '{"id":"CustomMenuWidget","name":"Social","menu_id":"social"}',
                'created_at' => '2016-12-24 02:41:57',
                'updated_at' => '2016-12-24 02:41:57',
            ),
            6 => 
            array (
                'id' => 30,
                'widget_id' => 'RecentPostsWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'ripple',
                'position' => 0,
                'data' => '{"id":"RecentPostsWidget","name":"Recent Posts","number_display":"5"}',
                'created_at' => '2016-12-24 02:42:58',
                'updated_at' => '2016-12-24 02:42:58',
            ),
            7 => 
            array (
                'id' => 31,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'ripple',
                'position' => 1,
                'data' => '{"id":"CustomMenuWidget","name":"Favorite website","menu_id":"favorite-website"}',
                'created_at' => '2016-12-24 02:42:58',
                'updated_at' => '2016-12-24 02:42:58',
            ),
            8 => 
            array (
                'id' => 32,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'ripple',
                'position' => 2,
                'data' => '{"id":"CustomMenuWidget","name":"My links","menu_id":"my-links"}',
                'created_at' => '2016-12-24 02:42:58',
                'updated_at' => '2016-12-24 02:42:58',
            ),
            9 => 
            array (
                'id' => 61,
                'widget_id' => 'RecentPostsWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'newstv',
                'position' => 0,
                'data' => '{"id":"RecentPostsWidget","name":"Recent posts","number_display":"6"}',
                'created_at' => '2017-04-30 15:56:39',
                'updated_at' => '2017-04-30 15:56:39',
            ),
            10 => 
            array (
                'id' => 62,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'newstv',
                'position' => 1,
                'data' => '{"id":"CustomMenuWidget","name":"Favorite websites","menu_id":"favorite-website"}',
                'created_at' => '2017-04-30 15:56:39',
                'updated_at' => '2017-04-30 15:56:39',
            ),
            11 => 
            array (
                'id' => 63,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'newstv',
                'position' => 2,
                'data' => '{"id":"CustomMenuWidget","name":"My links","menu_id":"my-links"}',
                'created_at' => '2017-04-30 15:56:39',
                'updated_at' => '2017-04-30 15:56:39',
            ),
            12 => 
            array (
                'id' => 64,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'newstv',
                'position' => 3,
                'data' => '{"id":"CustomMenuWidget","name":"Categories","menu_id":"featured-categories"}',
                'created_at' => '2017-04-30 15:56:39',
                'updated_at' => '2017-04-30 15:56:39',
            ),
            13 => 
            array (
                'id' => 74,
                'widget_id' => 'TagsWidget',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'ripple-vi',
                'position' => 0,
                'data' => '{"id":"TagsWidget","name":"Th\\u1ebb","number_display":"5"}',
                'created_at' => '2018-04-13 04:52:05',
                'updated_at' => '2018-04-13 04:52:05',
            ),
            14 => 
            array (
                'id' => 75,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'ripple-vi',
                'position' => 1,
                'data' => '{"id":"CustomMenuWidget","name":"Chuy\\u00ean m\\u1ee5c n\\u1ed5i b\\u1eadt","menu_id":"featured-categories"}',
                'created_at' => '2018-04-13 04:52:05',
                'updated_at' => '2018-04-13 04:52:05',
            ),
            15 => 
            array (
                'id' => 76,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'ripple-vi',
                'position' => 2,
                'data' => '{"id":"CustomMenuWidget","name":"M\\u1ea1ng x\\u00e3 h\\u1ed9i ","menu_id":"social"}',
                'created_at' => '2018-04-13 04:52:05',
                'updated_at' => '2018-04-13 04:52:05',
            ),
            16 => 
            array (
                'id' => 78,
                'widget_id' => 'RecentPostsWidget',
                'sidebar_id' => 'top_sidebar',
                'theme' => 'ripple-vi',
                'position' => 0,
                'data' => '{"id":"RecentPostsWidget","name":"B\\u00e0i vi\\u1ebft n\\u1ed5i b\\u1eadt","number_display":"5"}',
                'created_at' => '2018-04-13 04:52:59',
                'updated_at' => '2018-04-13 04:52:59',
            ),
            17 => 
            array (
                'id' => 89,
                'widget_id' => 'RecentPostsWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'ripple-vi',
                'position' => 0,
                'data' => '{"id":"RecentPostsWidget","name":"B\\u00e0i vi\\u1ebft n\\u1ed5i b\\u1eadt","number_display":"5"}',
                'created_at' => '2018-04-13 04:54:28',
                'updated_at' => '2018-04-13 04:54:28',
            ),
            18 => 
            array (
                'id' => 90,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'ripple-vi',
                'position' => 1,
                'data' => '{"id":"CustomMenuWidget","name":"Website \\u01b0a th\\u00edch","menu_id":"favorite-website"}',
                'created_at' => '2018-04-13 04:54:28',
                'updated_at' => '2018-04-13 04:54:28',
            ),
            19 => 
            array (
                'id' => 91,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'ripple-vi',
                'position' => 2,
                'data' => '{"id":"CustomMenuWidget","name":"Li\\u00ean k\\u1ebft ","menu_id":"main-menu"}',
                'created_at' => '2018-04-13 04:54:28',
                'updated_at' => '2018-04-13 04:54:28',
            ),
            20 => 
            array (
                'id' => 103,
                'widget_id' => 'PopularPostsWidget',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'newstv-vi',
                'position' => 0,
                'data' => '{"id":"PopularPostsWidget","name":"B\\u00e0i vi\\u1ebft n\\u1ed5i b\\u1eadt","number_display":"5"}',
                'created_at' => '2018-04-13 06:10:24',
                'updated_at' => '2018-04-13 06:10:24',
            ),
            21 => 
            array (
                'id' => 104,
                'widget_id' => 'VideoPostsWidget',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'newstv-vi',
                'position' => 1,
                'data' => '{"id":"VideoPostsWidget","name":"Video ","number_display":"4"}',
                'created_at' => '2018-04-13 06:10:24',
                'updated_at' => '2018-04-13 06:10:24',
            ),
            22 => 
            array (
                'id' => 105,
                'widget_id' => 'FacebookWidget',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'newstv-vi',
                'position' => 2,
                'data' => '{"id":"FacebookWidget","name":"Facebook","facebook_name":"Botble Technologies ","facebook_id":"https:\\/\\/www.facebook.com\\/botble.technologies\\/"}',
                'created_at' => '2018-04-13 06:10:24',
                'updated_at' => '2018-04-13 06:10:24',
            ),
            23 => 
            array (
                'id' => 131,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'newstv-vi',
                'position' => 0,
                'data' => '{"id":"CustomMenuWidget","name":"\\u001fWebsite \\u01b0a th\\u00edch ","menu_id":"favorite-website"}',
                'created_at' => '2018-04-13 06:12:50',
                'updated_at' => '2018-04-13 06:12:50',
            ),
            24 => 
            array (
                'id' => 132,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'newstv-vi',
                'position' => 1,
                'data' => '{"id":"CustomMenuWidget","name":"Li\\u00ean k\\u1ebft ","menu_id":"my-links"}',
                'created_at' => '2018-04-13 06:12:50',
                'updated_at' => '2018-04-13 06:12:50',
            ),
            25 => 
            array (
                'id' => 133,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'newstv-vi',
                'position' => 2,
                'data' => '{"id":"CustomMenuWidget","name":"\\u001fChuy\\u00ean m\\u1ee5c n\\u1ed5i b\\u1eadt ","menu_id":"featured-categories"}',
                'created_at' => '2018-04-13 06:12:50',
                'updated_at' => '2018-04-13 06:12:50',
            ),
            26 => 
            array (
                'id' => 134,
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'theme' => 'newstv-vi',
                'position' => 3,
                'data' => '{"id":"CustomMenuWidget","name":"M\\u1ea1ng x\\u00e3 h\\u1ed9i ","menu_id":"social"}',
                'created_at' => '2018-04-13 06:12:50',
                'updated_at' => '2018-04-13 06:12:50',
            ),
            27 => 
            array (
                'id' => 143,
                'widget_id' => 'PopularPostsWidget',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'newstv',
                'position' => 0,
                'data' => '{"id":"PopularPostsWidget","name":"Top Views","number_display":"5"}',
                'created_at' => '2019-11-03 12:32:32',
                'updated_at' => '2019-11-03 12:32:32',
            ),
            28 => 
            array (
                'id' => 144,
                'widget_id' => 'VideoPostsWidget',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'newstv',
                'position' => 1,
                'data' => '{"id":"VideoPostsWidget","name":"Videos","number_display":"1"}',
                'created_at' => '2019-11-03 12:32:32',
                'updated_at' => '2019-11-03 12:32:32',
            ),
            29 => 
            array (
                'id' => 145,
                'widget_id' => 'FacebookWidget',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'newstv',
                'position' => 2,
                'data' => '{"id":"FacebookWidget","name":"Facebook","facebook_name":"Botble Technologies","facebook_id":"https:\\/\\/www.facebook.com\\/botble.technologies"}',
                'created_at' => '2019-11-03 12:32:32',
                'updated_at' => '2019-11-03 12:32:32',
            ),
            30 => 
            array (
                'id' => 146,
                'widget_id' => 'AdsWidget',
                'sidebar_id' => 'primary_sidebar',
                'theme' => 'newstv',
                'position' => 3,
                'data' => '{"id":"AdsWidget","image_link":"#","image_new_tab":"0","image_url":"\\/storage\\/ads\\/300x250.jpg"}',
                'created_at' => '2019-11-03 12:32:32',
                'updated_at' => '2019-11-03 12:32:32',
            ),
        ));

        
    }
}