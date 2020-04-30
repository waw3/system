<?php

use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('oauth_clients')->delete();
        
        DB::table('oauth_clients')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => NULL,
                'name' => 'Laravel Personal Access Client',
                'secret' => 'nPvD6nCdZ4u5VDofwCaCrg9DTBpkMOJopp2JjdjR',
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2018-03-20 17:07:20',
                'updated_at' => '2018-03-20 17:07:20',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => NULL,
                'name' => 'Laravel Password Grant Client',
                'secret' => 'yoMn1m1jBDOZAAfwX7qOagkGrAoazmzujgLAfpyI',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2018-03-20 17:07:20',
                'updated_at' => '2018-03-20 17:07:20',
            ),
        ));

        
    }
}