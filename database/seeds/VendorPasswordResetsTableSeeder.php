<?php

use Illuminate\Database\Seeder;

class VendorPasswordResetsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('vendor_password_resets')->delete();
        

        
    }
}