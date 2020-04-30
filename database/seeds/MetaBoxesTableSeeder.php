<?php

use Illuminate\Database\Seeder;

class MetaBoxesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('meta_boxes')->delete();
        
        DB::table('meta_boxes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'reference_id' => 4,
                'meta_key' => 'seo_meta',
                'meta_value' => '[{"seo_title":null,"seo_keyword":null,"seo_description":null}]',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'created_at' => '2017-12-11 04:07:56',
                'updated_at' => '2017-12-11 04:07:56',
            ),
            1 => 
            array (
                'id' => 2,
                'reference_id' => 1,
                'meta_key' => 'seo_meta',
                'meta_value' => '[{"seo_title":null,"seo_description":null}]',
                'reference_type' => 'Modules\\Page\\Models\\Page',
                'created_at' => '2018-01-17 13:35:24',
                'updated_at' => '2019-03-11 15:30:22',
            ),
            2 => 
            array (
                'id' => 3,
                'reference_id' => 12,
                'meta_key' => 'seo_meta',
                'meta_value' => '[{"seo_title":null,"seo_keyword":null,"seo_description":null}]',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Category',
                'created_at' => '2018-04-13 05:02:12',
                'updated_at' => '2018-04-13 05:02:12',
            ),
            3 => 
            array (
                'id' => 12,
                'reference_id' => 49,
                'meta_key' => 'seo_meta',
                'meta_value' => '[{"seo_title":null,"seo_description":null}]',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'created_at' => '2018-04-13 05:41:28',
                'updated_at' => '2020-04-06 21:27:06',
            ),
            4 => 
            array (
                'id' => 15,
                'reference_id' => 8,
                'meta_key' => 'seo_meta',
                'meta_value' => '[{"seo_title":null,"seo_keyword":null,"seo_description":null}]',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Tag',
                'created_at' => '2018-04-13 05:42:20',
                'updated_at' => '2018-04-13 05:42:20',
            ),
            5 => 
            array (
                'id' => 16,
                'reference_id' => 9,
                'meta_key' => 'seo_meta',
                'meta_value' => '[{"seo_title":null,"seo_keyword":null,"seo_description":null}]',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Tag',
                'created_at' => '2018-04-13 05:42:20',
                'updated_at' => '2018-04-13 05:42:20',
            ),
            6 => 
            array (
                'id' => 17,
                'reference_id' => 51,
                'meta_key' => 'seo_meta',
                'meta_value' => '[{"seo_title":null,"seo_description":null}]',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'created_at' => '2018-04-13 05:43:09',
                'updated_at' => '2020-04-06 21:25:59',
            ),
            7 => 
            array (
                'id' => 18,
                'reference_id' => 10,
                'meta_key' => 'seo_meta',
                'meta_value' => '[{"seo_title":null,"seo_keyword":null,"seo_description":null}]',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Tag',
                'created_at' => '2018-04-13 05:43:09',
                'updated_at' => '2018-04-13 05:43:09',
            ),
            8 => 
            array (
                'id' => 23,
                'reference_id' => 25,
                'meta_key' => 'seo_meta',
                'meta_value' => '[{"seo_title":null,"seo_keyword":null,"seo_description":null}]',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Tag',
                'created_at' => '2018-04-13 06:00:35',
                'updated_at' => '2018-04-13 06:00:35',
            ),
            9 => 
            array (
                'id' => 25,
                'reference_id' => 53,
                'meta_key' => 'seo_meta',
                'meta_value' => '[{"seo_title":null,"seo_description":null}]',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'created_at' => '2018-04-13 06:02:59',
                'updated_at' => '2020-04-06 21:23:48',
            ),
            10 => 
            array (
                'id' => 29,
                'reference_id' => 46,
                'meta_key' => 'seo_meta',
                'meta_value' => '[{"seo_title":null,"seo_description":null}]',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'created_at' => '2020-04-06 21:25:08',
                'updated_at' => '2020-04-06 21:25:08',
            ),
            11 => 
            array (
                'id' => 30,
                'reference_id' => 18,
                'meta_key' => 'seo_meta',
                'meta_value' => '[{"seo_title":null,"seo_description":null}]',
                'reference_type' => 'Modules\\Page\\Models\\Page',
                'created_at' => '2020-04-23 08:48:12',
                'updated_at' => '2020-04-23 08:48:12',
            ),
        ));

        
    }
}