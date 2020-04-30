<?php

use Illuminate\Database\Seeder;

class MemberActivityLogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('member_activity_logs')->delete();
        

        
    }
}