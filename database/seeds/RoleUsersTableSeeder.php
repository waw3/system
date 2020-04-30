<?php

use Illuminate\Database\Seeder;

class RoleUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_users')->delete();
        
        DB::table('role_users')->insert(array (
            0 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'role_id' => 1,
                'created_at' => '2018-01-18 03:11:34',
                'updated_at' => '2018-01-18 03:11:34',
            ),
        ));

        
    }
}