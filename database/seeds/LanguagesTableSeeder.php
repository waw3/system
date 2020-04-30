<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('languages')->delete();
        
        DB::table('languages')->insert(array (
            0 => 
            array (
                'lang_id' => 44,
                'lang_name' => 'English',
                'lang_locale' => 'en',
                'lang_code' => 'en_US',
                'lang_flag' => 'us',
                'lang_is_default' => 1,
                'lang_order' => 0,
                'lang_is_rtl' => 0,
            ),
        ));

        
    }
}