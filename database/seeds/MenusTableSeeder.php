<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menus')->delete();
        
        DB::table('menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Main menu',
                'slug' => 'main-menu',
                'status' => 'published',
                'created_at' => '2016-06-17 13:53:45',
                'updated_at' => '2016-08-14 16:25:34',
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'Top Right Menu',
                'slug' => 'right-menu',
                'status' => 'published',
                'created_at' => '2016-08-02 23:20:10',
                'updated_at' => '2016-09-27 04:30:46',
            ),
            2 => 
            array (
                'id' => 6,
                'name' => 'Social',
                'slug' => 'social',
                'status' => 'published',
                'created_at' => '2016-10-19 19:26:54',
                'updated_at' => '2016-10-19 19:26:54',
            ),
            3 => 
            array (
                'id' => 7,
                'name' => 'Favorite website',
                'slug' => 'favorite-website',
                'status' => 'published',
                'created_at' => '2016-10-21 06:21:23',
                'updated_at' => '2016-10-21 06:21:23',
            ),
            4 => 
            array (
                'id' => 8,
                'name' => 'My links',
                'slug' => 'my-links',
                'status' => 'published',
                'created_at' => '2016-10-21 06:24:36',
                'updated_at' => '2016-10-21 06:24:36',
            ),
            5 => 
            array (
                'id' => 9,
                'name' => 'Featured Categories',
                'slug' => 'featured-categories',
                'status' => 'published',
                'created_at' => '2016-10-21 06:52:59',
                'updated_at' => '2016-10-21 06:52:59',
            ),
        ));

        
    }
}