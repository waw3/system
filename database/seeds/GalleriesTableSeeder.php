<?php

use Illuminate\Database\Seeder;

class GalleriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('galleries')->delete();
        
        DB::table('galleries')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Photography',
                'description' => 'This is description',
                'status' => 'published',
                'is_featured' => 1,
                'order' => 0,
                'image' => 'galleries/1476521053-volkswagen-id-paris-motor-show-4k-1280x720.jpg',
                'user_id' => 1,
                'created_at' => '2016-10-13 05:49:13',
                'updated_at' => '2019-09-13 13:03:28',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Nature',
                'description' => 'Nature gallery',
                'status' => 'published',
                'is_featured' => 1,
                'order' => 0,
                'image' => 'galleries/1476513483-misty-mountains-1280x720.jpg',
                'user_id' => 1,
                'created_at' => '2016-10-13 05:56:07',
                'updated_at' => '2019-09-13 13:03:28',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'New Day',
                'description' => 'This is demo gallery',
                'status' => 'published',
                'is_featured' => 1,
                'order' => 0,
                'image' => 'galleries/1476520418-supergirl-season-2-1280x720.jpg',
                'user_id' => 1,
                'created_at' => '2016-10-13 05:56:44',
                'updated_at' => '2019-09-13 13:03:28',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Morning',
                'description' => 'Hello',
                'status' => 'published',
                'is_featured' => 1,
                'order' => 0,
                'image' => 'galleries/1476513486-power-rangers-red-ranger-4k-1280x720.jpg',
                'user_id' => 1,
                'created_at' => '2016-10-13 05:57:30',
                'updated_at' => '2019-09-13 13:03:29',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Happy day',
                'description' => 'Demo',
                'status' => 'published',
                'is_featured' => 1,
                'order' => 0,
                'image' => 'galleries/1476513488-spectacular-sunrise-4k-1280x720.jpg',
                'user_id' => 1,
                'created_at' => '2016-10-13 05:58:11',
                'updated_at' => '2019-09-13 13:03:29',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Perfect',
                'description' => 'This is perfect description',
                'status' => 'published',
                'is_featured' => 1,
                'order' => 0,
                'image' => 'galleries/1476513493-world-of-tanks-football-event-1280x720.jpg',
                'user_id' => 1,
                'created_at' => '2016-10-13 05:58:40',
                'updated_at' => '2019-09-13 13:03:29',
            ),
        ));

        
    }
}