<?php

use Illuminate\Database\Seeder;

class DashboardWidgetsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dashboard_widgets')->delete();
        
        DB::table('dashboard_widgets')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'widget_posts_recent',
                'created_at' => '2017-11-30 13:26:50',
                'updated_at' => '2017-11-30 13:26:50',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'widget_analytics_general',
                'created_at' => '2017-11-30 13:26:50',
                'updated_at' => '2017-11-30 13:26:50',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'widget_analytics_page',
                'created_at' => '2017-11-30 13:26:50',
                'updated_at' => '2017-11-30 13:26:50',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'widget_analytics_browser',
                'created_at' => '2017-11-30 13:26:50',
                'updated_at' => '2017-11-30 13:26:50',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'widget_analytics_referrer',
                'created_at' => '2017-11-30 13:26:50',
                'updated_at' => '2017-11-30 13:26:50',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'widget_audit_logs',
                'created_at' => '2017-11-30 13:26:50',
                'updated_at' => '2017-11-30 13:26:50',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'widget_request_errors',
                'created_at' => '2017-11-30 13:26:50',
                'updated_at' => '2017-11-30 13:26:50',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'widget_total_plugins',
                'created_at' => '2019-03-11 15:29:10',
                'updated_at' => '2019-03-11 15:29:10',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'widget_total_pages',
                'created_at' => '2019-03-11 15:29:10',
                'updated_at' => '2019-03-11 15:29:10',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'widget_total_users',
                'created_at' => '2019-03-11 15:29:10',
                'updated_at' => '2019-03-11 15:29:10',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'widget_total_themes',
                'created_at' => '2019-03-11 15:29:10',
                'updated_at' => '2019-03-11 15:29:10',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'widget_products_recent',
                'created_at' => '2020-04-26 05:36:16',
                'updated_at' => '2020-04-26 05:36:16',
            ),
        ));

        
    }
}