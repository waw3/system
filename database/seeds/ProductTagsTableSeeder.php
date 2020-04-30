<?php

use Illuminate\Database\Seeder;

class ProductTagsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_tags')->delete();
        

        
    }
}