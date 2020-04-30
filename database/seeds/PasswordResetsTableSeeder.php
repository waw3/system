<?php

use Illuminate\Database\Seeder;

class PasswordResetsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('password_resets')->delete();
        
        DB::table('password_resets')->insert(array (
            0 => 
            array (
                'email' => 'minhsang2603@gmail.com',
                'token' => '$2y$10$kWX7Vm.TR02TvQ426QLR2uzK6/JjiYIwE.ruTXH6eBQdS8mV5aL0a',
                'created_at' => '2018-01-23 22:40:43',
            ),
        ));

        
    }
}