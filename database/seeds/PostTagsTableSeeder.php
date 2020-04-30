<?php

use Illuminate\Database\Seeder;

class PostTagsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('post_tags')->delete();
        
        DB::table('post_tags')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tag_id' => 1,
                'post_id' => 2,
            ),
            1 => 
            array (
                'id' => 2,
                'tag_id' => 2,
                'post_id' => 2,
            ),
            2 => 
            array (
                'id' => 3,
                'tag_id' => 3,
                'post_id' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'tag_id' => 4,
                'post_id' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'tag_id' => 1,
                'post_id' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'tag_id' => 5,
                'post_id' => 6,
            ),
            6 => 
            array (
                'id' => 7,
                'tag_id' => 6,
                'post_id' => 6,
            ),
            7 => 
            array (
                'id' => 8,
                'tag_id' => 5,
                'post_id' => 8,
            ),
            8 => 
            array (
                'id' => 9,
                'tag_id' => 6,
                'post_id' => 8,
            ),
            9 => 
            array (
                'id' => 10,
                'tag_id' => 5,
                'post_id' => 9,
            ),
            10 => 
            array (
                'id' => 11,
                'tag_id' => 6,
                'post_id' => 9,
            ),
            11 => 
            array (
                'id' => 12,
                'tag_id' => 5,
                'post_id' => 10,
            ),
            12 => 
            array (
                'id' => 13,
                'tag_id' => 6,
                'post_id' => 10,
            ),
            13 => 
            array (
                'id' => 14,
                'tag_id' => 5,
                'post_id' => 11,
            ),
            14 => 
            array (
                'id' => 15,
                'tag_id' => 6,
                'post_id' => 11,
            ),
            15 => 
            array (
                'id' => 16,
                'tag_id' => 5,
                'post_id' => 12,
            ),
            16 => 
            array (
                'id' => 17,
                'tag_id' => 6,
                'post_id' => 12,
            ),
            17 => 
            array (
                'id' => 18,
                'tag_id' => 5,
                'post_id' => 13,
            ),
            18 => 
            array (
                'id' => 19,
                'tag_id' => 6,
                'post_id' => 13,
            ),
            19 => 
            array (
                'id' => 20,
                'tag_id' => 5,
                'post_id' => 14,
            ),
            20 => 
            array (
                'id' => 21,
                'tag_id' => 6,
                'post_id' => 14,
            ),
            21 => 
            array (
                'id' => 22,
                'tag_id' => 5,
                'post_id' => 15,
            ),
            22 => 
            array (
                'id' => 23,
                'tag_id' => 6,
                'post_id' => 15,
            ),
            23 => 
            array (
                'id' => 24,
                'tag_id' => 5,
                'post_id' => 16,
            ),
            24 => 
            array (
                'id' => 25,
                'tag_id' => 6,
                'post_id' => 16,
            ),
            25 => 
            array (
                'id' => 26,
                'tag_id' => 5,
                'post_id' => 17,
            ),
            26 => 
            array (
                'id' => 27,
                'tag_id' => 6,
                'post_id' => 17,
            ),
            27 => 
            array (
                'id' => 28,
                'tag_id' => 5,
                'post_id' => 18,
            ),
            28 => 
            array (
                'id' => 29,
                'tag_id' => 6,
                'post_id' => 18,
            ),
            29 => 
            array (
                'id' => 30,
                'tag_id' => 5,
                'post_id' => 19,
            ),
            30 => 
            array (
                'id' => 31,
                'tag_id' => 6,
                'post_id' => 19,
            ),
            31 => 
            array (
                'id' => 32,
                'tag_id' => 5,
                'post_id' => 20,
            ),
            32 => 
            array (
                'id' => 33,
                'tag_id' => 6,
                'post_id' => 20,
            ),
            33 => 
            array (
                'id' => 34,
                'tag_id' => 5,
                'post_id' => 21,
            ),
            34 => 
            array (
                'id' => 35,
                'tag_id' => 6,
                'post_id' => 21,
            ),
        ));

        
    }
}