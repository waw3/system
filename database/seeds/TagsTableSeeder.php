<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tags')->delete();
        
        DB::table('tags')->insert(array (
            0 => 
            array (
                'id' => 5,
                'name' => 'download',
                'author_id' => 1,
                'author_type' => 'Modules\\ACL\\Models\\User',
                'description' => '',
                'status' => 'published',
                'created_at' => '2016-08-02 17:38:34',
                'updated_at' => '2016-09-27 05:30:37',
            ),
            1 => 
            array (
                'id' => 6,
                'name' => 'event',
                'author_id' => 1,
                'author_type' => 'Modules\\ACL\\Models\\User',
                'description' => '',
                'status' => 'published',
                'created_at' => '2016-08-02 17:38:34',
                'updated_at' => '2016-09-27 05:30:50',
            ),
            2 => 
            array (
                'id' => 25,
                'name' => 'popular',
                'author_id' => 1,
                'author_type' => 'Modules\\ACL\\Models\\User',
                'description' => NULL,
                'status' => 'published',
                'created_at' => '2018-04-13 06:00:35',
                'updated_at' => '2018-04-13 06:00:35',
            ),
        ));

        
    }
}