<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'email' => 'admin@botble.com',
                'password' => '$2y$10$SRfyqQQlZWYmzMDzcU9xcOL9KW2CH.jk6rZGqSVU32PiAZSBYS94K',
                'remember_token' => 'A4wUrTEswrFH6puT87WJC3e7EsxbR6KR1dNsYh9yvvxfBDL5wzW0uUrBUkgy',
                'created_at' => '2017-11-15 01:57:09',
                'updated_at' => '2020-04-26 14:49:54',
                'permissions' => '{"superuser":1,"manage_supers":1}',
                'last_login' => '2020-04-26 10:06:08',
                'first_name' => 'System',
                'last_name' => 'Admin',
                'username' => 'admin',
                'super_user' => 1,
                'manage_supers' => 1,
                'avatar_id' => 121,
                'stripe_id' => NULL,
                'card_brand' => NULL,
                'card_last_four' => NULL,
                'trial_ends_at' => NULL,
            ),
        ));

        
    }
}