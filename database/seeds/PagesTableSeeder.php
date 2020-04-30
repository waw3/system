<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pages')->delete();
        
        DB::table('pages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Contact',
                'content' => '<p>Address: North Link Building, 10 Admiralty Street, 757695 Singapore</p>

<p>Hotline: 18006268</p>

<p>Email: contact@botble.com</p>

<p>[google-map]North Link Building, 10 Admiralty Street, 757695 Singapore[/google-map]</p>

<p>For the fastest reply, please use the contact form below.</p>

<p>[contact-form][/contact-form]</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>',
                'status' => 'published',
                'user_id' => 1,
                'image' => 'https://s3-ap-southeast-1.amazonaws.com/botble/cms/galleries/1476520641-elena-siberian-tigress-4k-1280x720.jpg',
                'template' => 'default',
                'is_featured' => 0,
                'description' => NULL,
                'created_at' => '2016-07-08 21:05:39',
                'updated_at' => '2020-04-06 21:43:17',
            ),
            1 => 
            array (
                'id' => 18,
                'name' => 'Test',
                'content' => '<p>[google-map]4325 Timber Ridge TRL SW APT 12[/google-map]</p>

<p>&nbsp;</p>

<p>[contact-form][/contact-form]</p>

<p>&nbsp;</p>',
                'status' => 'published',
                'user_id' => 1,
                'image' => NULL,
                'template' => 'default',
                'is_featured' => 1,
                'description' => 'this is the short description',
                'created_at' => '2020-04-23 08:48:12',
                'updated_at' => '2020-04-26 17:34:45',
            ),
        ));

        
    }
}