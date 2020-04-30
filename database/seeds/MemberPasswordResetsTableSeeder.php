<?php

use Illuminate\Database\Seeder;

class MemberPasswordResetsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('member_password_resets')->delete();
        

        
    }
}