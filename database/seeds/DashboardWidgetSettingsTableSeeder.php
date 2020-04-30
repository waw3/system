<?php

use Illuminate\Database\Seeder;

class DashboardWidgetSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dashboard_widget_settings')->delete();
        
        DB::table('dashboard_widget_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'settings' => NULL,
                'user_id' => 1,
                'widget_id' => 1,
                'order' => 2,
                'status' => 1,
                'created_at' => '2017-11-30 13:27:00',
                'updated_at' => '2020-04-26 17:40:29',
            ),
            1 => 
            array (
                'id' => 2,
                'settings' => NULL,
                'user_id' => 1,
                'widget_id' => 3,
                'order' => 7,
                'status' => 1,
                'created_at' => '2017-11-30 13:27:00',
                'updated_at' => '2020-04-26 17:03:57',
            ),
            2 => 
            array (
                'id' => 3,
                'settings' => NULL,
                'user_id' => 1,
                'widget_id' => 4,
                'order' => 1,
                'status' => 1,
                'created_at' => '2017-11-30 13:27:00',
                'updated_at' => '2020-04-26 17:40:29',
            ),
            3 => 
            array (
                'id' => 4,
                'settings' => NULL,
                'user_id' => 1,
                'widget_id' => 5,
                'order' => 3,
                'status' => 1,
                'created_at' => '2017-11-30 13:27:00',
                'updated_at' => '2020-04-26 17:03:57',
            ),
            4 => 
            array (
                'id' => 5,
                'settings' => NULL,
                'user_id' => 1,
                'widget_id' => 6,
                'order' => 5,
                'status' => 1,
                'created_at' => '2017-11-30 13:27:00',
                'updated_at' => '2020-04-26 17:03:57',
            ),
            5 => 
            array (
                'id' => 6,
                'settings' => NULL,
                'user_id' => 1,
                'widget_id' => 7,
                'order' => 6,
                'status' => 1,
                'created_at' => '2017-11-30 13:27:00',
                'updated_at' => '2020-04-26 17:03:57',
            ),
            6 => 
            array (
                'id' => 7,
                'settings' => NULL,
                'user_id' => 1,
                'widget_id' => 2,
                'order' => 0,
                'status' => 1,
                'created_at' => '2017-11-30 13:27:00',
                'updated_at' => '2020-04-26 17:04:03',
            ),
            7 => 
            array (
                'id' => 8,
                'settings' => NULL,
                'user_id' => 1,
                'widget_id' => 12,
                'order' => 4,
                'status' => 1,
                'created_at' => '2020-04-26 16:56:59',
                'updated_at' => '2020-04-26 17:03:57',
            ),
            8 => 
            array (
                'id' => 9,
                'settings' => NULL,
                'user_id' => 1,
                'widget_id' => 8,
                'order' => 0,
                'status' => 1,
                'created_at' => '2020-04-26 17:03:37',
                'updated_at' => '2020-04-26 17:03:37',
            ),
            9 => 
            array (
                'id' => 10,
                'settings' => NULL,
                'user_id' => 1,
                'widget_id' => 9,
                'order' => 0,
                'status' => 1,
                'created_at' => '2020-04-26 17:03:37',
                'updated_at' => '2020-04-26 17:03:37',
            ),
            10 => 
            array (
                'id' => 11,
                'settings' => NULL,
                'user_id' => 1,
                'widget_id' => 10,
                'order' => 0,
                'status' => 1,
                'created_at' => '2020-04-26 17:03:37',
                'updated_at' => '2020-04-26 17:03:37',
            ),
            11 => 
            array (
                'id' => 12,
                'settings' => NULL,
                'user_id' => 1,
                'widget_id' => 11,
                'order' => 0,
                'status' => 1,
                'created_at' => '2020-04-26 17:03:37',
                'updated_at' => '2020-04-26 17:03:37',
            ),
        ));

        
    }
}