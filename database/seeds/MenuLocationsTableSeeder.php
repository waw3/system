<?php

use Illuminate\Database\Seeder;

class MenuLocationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menu_locations')->delete();
        
        DB::table('menu_locations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'menu_id' => 1,
                'location' => 'main-menu',
                'created_at' => '2018-11-29 04:19:48',
                'updated_at' => '2018-11-29 04:19:48',
            ),
            1 => 
            array (
                'id' => 2,
                'menu_id' => 10,
                'location' => 'main-menu',
                'created_at' => '2018-11-29 04:19:55',
                'updated_at' => '2018-11-29 04:19:55',
            ),
            2 => 
            array (
                'id' => 3,
                'menu_id' => 6,
                'location' => 'header-menu',
                'created_at' => '2018-11-29 04:20:42',
                'updated_at' => '2018-11-29 04:20:42',
            ),
        ));

        
    }
}