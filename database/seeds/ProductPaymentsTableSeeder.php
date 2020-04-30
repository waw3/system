<?php

use Illuminate\Database\Seeder;

class ProductPaymentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_payments')->delete();
        

        
    }
}