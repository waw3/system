<?php

use Illuminate\Database\Seeder;

class OrderstatusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('orderstatuses')->delete();
        

        
    }
}