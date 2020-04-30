<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'slug' => 'administrators',
                'name' => 'Administrators',
                'permissions' => '',
                'description' => 'Highest role in system',
                'is_default' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-01-17 13:00:45',
                'updated_at' => '2020-04-26 14:49:54',
            ),
            1 => 
            array (
                'id' => 2,
                'slug' => 'members',
                'name' => 'Members',
                'permissions' => '{"analytics.general":true,"analytics.page":true,"analytics.browser":true,"analytics.referrer":true,"block.list":true,"block.create":true,"block.edit":true,"block.delete":true,"categories.list":true,"categories.create":true,"categories.edit":true,"categories.delete":true,"contacts.list":true,"contacts.create":true,"contacts.edit":true,"contacts.delete":true,"custom-fields.list":true,"custom-fields.create":true,"custom-fields.edit":true,"custom-fields.delete":true,"dashboard.index":true,"galleries.list":true,"galleries.create":true,"galleries.edit":true,"galleries.delete":true,"media.index":true,"files.list":true,"files.create":true,"files.edit":true,"files.trash":true,"files.delete":true,"folders.list":true,"folders.create":true,"folders.edit":true,"folders.trash":true,"folders.delete":true,"menus.list":true,"menus.create":true,"menus.edit":true,"menus.delete":true,"pages.list":true,"pages.create":true,"pages.edit":true,"pages.delete":true,"posts.list":true,"posts.create":true,"posts.edit":true,"posts.delete":true,"tags.list":true,"tags.create":true,"tags.edit":true,"tags.delete":true}',
                'description' => 'Member role',
                'is_default' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-01-17 13:01:32',
                'updated_at' => '2018-03-14 17:50:43',
            ),
        ));

        
    }
}