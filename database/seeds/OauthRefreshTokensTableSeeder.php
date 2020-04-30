<?php

use Illuminate\Database\Seeder;

class OauthRefreshTokensTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('oauth_refresh_tokens')->delete();
        
        DB::table('oauth_refresh_tokens')->insert(array (
            0 => 
            array (
                'id' => '09a880ccdf4f35761565b221378b611954a090fd48a2a710b1531feccced42a104d7208d38508258',
                'access_token_id' => '6ec25d436833eb08e9c574e208ce65ee59561517d49f0ac952d292eb80d976bfb11805a6e28f94dc',
                'revoked' => 0,
                'expires_at' => '2018-04-20 04:08:18',
            ),
        ));

        
    }
}