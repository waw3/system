<?php

use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('contacts')->delete();
        
        DB::table('contacts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Demo contact',
                'email' => 'admin@admin.com',
                'phone' => '0123456789',
                'address' => 'Somewhere in the world',
                'content' => 'The sample content',
                'subject' => NULL,
                'created_at' => '2017-01-15 16:19:27',
                'updated_at' => '2017-01-15 16:25:47',
                'status' => 'unread',
            ),
        ));

        
    }
}