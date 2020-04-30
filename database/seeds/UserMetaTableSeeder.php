<?php

use Illuminate\Database\Seeder;

class UserMetaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_meta')->delete();
        
        DB::table('user_meta')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'languages_current_data_language',
                'value' => 'en_US',
                'user_id' => 1,
                'created_at' => '2017-11-30 13:27:51',
                'updated_at' => '2018-04-13 06:00:39',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'admin-theme',
                'value' => 'darkblue',
                'user_id' => 1,
                'created_at' => '2018-03-06 22:42:13',
                'updated_at' => '2020-04-23 09:21:41',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'admin-locale',
                'value' => 'en',
                'user_id' => 1,
                'created_at' => '2018-03-06 22:42:14',
                'updated_at' => '2018-07-03 23:37:40',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'site-locale',
                'value' => 'en',
                'user_id' => 1,
                'created_at' => '2020-04-23 09:27:09',
                'updated_at' => '2020-04-23 09:27:14',
            ),
        ));

        
    }
}