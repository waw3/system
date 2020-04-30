<?php

use Illuminate\Database\Seeder;

class PostCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('post_categories')->delete();
        
        DB::table('post_categories')->insert(array (
            0 => 
            array (
                'id' => 14,
                'category_id' => 1,
                'post_id' => 3,
            ),
            1 => 
            array (
                'id' => 37,
                'category_id' => 1,
                'post_id' => 1,
            ),
            2 => 
            array (
                'id' => 48,
                'category_id' => 1,
                'post_id' => 2,
            ),
            3 => 
            array (
                'id' => 94,
                'category_id' => 1,
                'post_id' => 22,
            ),
            4 => 
            array (
                'id' => 162,
                'category_id' => 8,
                'post_id' => 22,
            ),
            5 => 
            array (
                'id' => 164,
                'category_id' => 6,
                'post_id' => 23,
            ),
            6 => 
            array (
                'id' => 165,
                'category_id' => 9,
                'post_id' => 26,
            ),
            7 => 
            array (
                'id' => 166,
                'category_id' => 7,
                'post_id' => 27,
            ),
            8 => 
            array (
                'id' => 167,
                'category_id' => 7,
                'post_id' => 28,
            ),
            9 => 
            array (
                'id' => 168,
                'category_id' => 8,
                'post_id' => 29,
            ),
            10 => 
            array (
                'id' => 171,
                'category_id' => 7,
                'post_id' => 30,
            ),
            11 => 
            array (
                'id' => 172,
                'category_id' => 8,
                'post_id' => 31,
            ),
            12 => 
            array (
                'id' => 173,
                'category_id' => 6,
                'post_id' => 37,
            ),
            13 => 
            array (
                'id' => 175,
                'category_id' => 8,
                'post_id' => 38,
            ),
            14 => 
            array (
                'id' => 176,
                'category_id' => 7,
                'post_id' => 39,
            ),
            15 => 
            array (
                'id' => 177,
                'category_id' => 8,
                'post_id' => 40,
            ),
            16 => 
            array (
                'id' => 179,
                'category_id' => 9,
                'post_id' => 41,
            ),
            17 => 
            array (
                'id' => 181,
                'category_id' => 7,
                'post_id' => 42,
            ),
            18 => 
            array (
                'id' => 186,
                'category_id' => 8,
                'post_id' => 43,
            ),
            19 => 
            array (
                'id' => 252,
                'category_id' => 11,
                'post_id' => 10,
            ),
            20 => 
            array (
                'id' => 255,
                'category_id' => 11,
                'post_id' => 13,
            ),
            21 => 
            array (
                'id' => 262,
                'category_id' => 1,
                'post_id' => 20,
            ),
            22 => 
            array (
                'id' => 263,
                'category_id' => 1,
                'post_id' => 21,
            ),
            23 => 
            array (
                'id' => 279,
                'category_id' => 1,
                'post_id' => 8,
            ),
            24 => 
            array (
                'id' => 280,
                'category_id' => 11,
                'post_id' => 9,
            ),
            25 => 
            array (
                'id' => 287,
                'category_id' => 6,
                'post_id' => 6,
            ),
            26 => 
            array (
                'id' => 289,
                'category_id' => 1,
                'post_id' => 5,
            ),
            27 => 
            array (
                'id' => 290,
                'category_id' => 1,
                'post_id' => 7,
            ),
            28 => 
            array (
                'id' => 295,
                'category_id' => 8,
                'post_id' => 17,
            ),
            29 => 
            array (
                'id' => 302,
                'category_id' => 6,
                'post_id' => 18,
            ),
            30 => 
            array (
                'id' => 303,
                'category_id' => 7,
                'post_id' => 16,
            ),
            31 => 
            array (
                'id' => 306,
                'category_id' => 8,
                'post_id' => 15,
            ),
            32 => 
            array (
                'id' => 308,
                'category_id' => 1,
                'post_id' => 19,
            ),
            33 => 
            array (
                'id' => 310,
                'category_id' => 9,
                'post_id' => 14,
            ),
            34 => 
            array (
                'id' => 313,
                'category_id' => 11,
                'post_id' => 12,
            ),
            35 => 
            array (
                'id' => 314,
                'category_id' => 9,
                'post_id' => 11,
            ),
            36 => 
            array (
                'id' => 315,
                'category_id' => 6,
                'post_id' => 4,
            ),
            37 => 
            array (
                'id' => 347,
                'category_id' => 6,
                'post_id' => 46,
            ),
        ));

        
    }
}