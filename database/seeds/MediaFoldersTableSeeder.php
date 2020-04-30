<?php

use Illuminate\Database\Seeder;

class MediaFoldersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('media_folders')->delete();
        
        DB::table('media_folders')->insert(array (
            0 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'name' => 'news',
                'slug' => 'news',
                'parent_id' => 0,
                'created_at' => '2019-09-13 13:09:12',
                'updated_at' => '2019-09-13 13:09:12',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 4,
                'user_id' => 1,
                'name' => 'galleries',
                'slug' => 'galleries',
                'parent_id' => 0,
                'created_at' => '2019-09-13 13:14:34',
                'updated_at' => '2019-09-13 13:14:34',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 5,
                'user_id' => 1,
                'name' => 'logo',
                'slug' => 'logo',
                'parent_id' => 0,
                'created_at' => '2019-09-13 13:15:52',
                'updated_at' => '2019-09-13 13:15:52',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 6,
                'user_id' => 1,
                'name' => 'ads',
                'slug' => 'ads',
                'parent_id' => 0,
                'created_at' => '2019-11-03 12:28:35',
                'updated_at' => '2019-11-03 12:28:35',
                'deleted_at' => NULL,
            ),
        ));

        
    }
}