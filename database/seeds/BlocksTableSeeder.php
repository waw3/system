<?php

use Illuminate\Database\Seeder;

class BlocksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('blocks')->delete();
        
        DB::table('blocks')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Sample block',
                'alias' => 'sample-block',
                'description' => 'This is a sample block',
                'content' => '<p><span style="color:#e67e22;">This block will be shown on the contact page!</span></p>',
                'status' => 'published',
                'user_id' => 1,
                'created_at' => '2019-03-11 15:30:01',
                'updated_at' => '2019-03-11 15:30:01',
            ),
        ));

        
    }
}