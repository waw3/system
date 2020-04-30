<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Uncategorized',
                'parent_id' => 0,
                'description' => 'Demo',
                'status' => 'published',
                'author_id' => 0,
                'author_type' => 'Modules\\ACL\\Models\\User',
                'icon' => '',
                'is_featured' => 0,
                'order' => 0,
                'is_default' => 1,
                'created_at' => '2016-07-09 12:32:39',
                'updated_at' => '2016-11-25 02:31:58',
            ),
            1 => 
            array (
                'id' => 6,
                'name' => 'Events',
                'parent_id' => 0,
                'description' => 'Event description',
                'status' => 'published',
                'author_id' => 1,
                'author_type' => 'Modules\\ACL\\Models\\User',
                'icon' => '',
                'is_featured' => 1,
                'order' => 0,
                'is_default' => 0,
                'created_at' => '2016-08-02 18:13:34',
                'updated_at' => '2016-11-25 02:32:02',
            ),
            2 => 
            array (
                'id' => 7,
                'name' => 'Projects',
                'parent_id' => 6,
                'description' => 'Projects description',
                'status' => 'published',
                'author_id' => 1,
                'author_type' => 'Modules\\ACL\\Models\\User',
                'icon' => NULL,
                'is_featured' => 0,
                'order' => 3,
                'is_default' => 0,
                'created_at' => '2016-08-02 18:13:52',
                'updated_at' => '2017-04-30 15:58:41',
            ),
            3 => 
            array (
                'id' => 8,
                'name' => 'Portfolio',
                'parent_id' => 9,
                'description' => 'Description',
                'status' => 'published',
                'author_id' => 1,
                'author_type' => 'Modules\\ACL\\Models\\User',
                'icon' => NULL,
                'is_featured' => 0,
                'order' => 0,
                'is_default' => 0,
                'created_at' => '2016-09-27 05:32:06',
                'updated_at' => '2017-04-30 15:58:21',
            ),
            4 => 
            array (
                'id' => 9,
                'name' => 'Business',
                'parent_id' => 0,
                'description' => 'Business',
                'status' => 'published',
                'author_id' => 1,
                'author_type' => 'Modules\\ACL\\Models\\User',
                'icon' => NULL,
                'is_featured' => 1,
                'order' => 2,
                'is_default' => 0,
                'created_at' => '2016-09-28 05:38:25',
                'updated_at' => '2017-04-30 15:59:12',
            ),
            5 => 
            array (
                'id' => 10,
                'name' => 'Resources',
                'parent_id' => 11,
                'description' => 'Resource',
                'status' => 'published',
                'author_id' => 1,
                'author_type' => 'Modules\\ACL\\Models\\User',
                'icon' => NULL,
                'is_featured' => 0,
                'order' => 4,
                'is_default' => 0,
                'created_at' => '2016-09-28 05:39:46',
                'updated_at' => '2017-04-30 15:58:55',
            ),
            6 => 
            array (
                'id' => 11,
                'name' => 'New & Updates',
                'parent_id' => 0,
                'description' => 'News and Update',
                'status' => 'published',
                'author_id' => 1,
                'author_type' => 'Modules\\ACL\\Models\\User',
                'icon' => '',
                'is_featured' => 1,
                'order' => 5,
                'is_default' => 0,
                'created_at' => '2016-09-28 05:40:25',
                'updated_at' => '2016-11-25 02:31:56',
            ),
            7 => 
            array (
                'id' => 12,
                'name' => 'Chưa phân loại',
                'parent_id' => 0,
                'description' => 'Chuyên mục chưa phân loại',
                'status' => 'published',
                'author_id' => 1,
                'author_type' => 'Modules\\ACL\\Models\\User',
                'icon' => NULL,
                'is_featured' => 0,
                'order' => 1,
                'is_default' => 1,
                'created_at' => '2018-04-13 05:02:12',
                'updated_at' => '2018-04-13 05:02:12',
            ),
        ));

        
    }
}