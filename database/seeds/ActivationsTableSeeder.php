<?php

use Illuminate\Database\Seeder;

class ActivationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('activations')->delete();
        
        DB::table('activations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'code' => 'ZLKcLRxzQH9E8XMMWd6NITIH1J8Qdljb',
                'completed' => 1,
                'completed_at' => '2017-11-15 01:57:09',
                'created_at' => '2017-11-15 01:57:09',
                'updated_at' => '2017-11-15 01:57:09',
            ),
        ));

        
    }
}