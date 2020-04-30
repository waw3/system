<?php

use Illuminate\Database\Seeder;

class RevisionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('revisions')->delete();
        
        DB::table('revisions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 44,
                'user_id' => 1,
                'key' => 'featured',
                'old_value' => '0',
                'new_value' => '1',
                'created_at' => '2018-04-13 05:38:58',
                'updated_at' => '2018-04-13 05:38:58',
            ),
            1 => 
            array (
                'id' => 2,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 48,
                'user_id' => 1,
                'key' => 'image',
                'old_value' => NULL,
                'new_value' => 'https://s3-ap-southeast-1.amazonaws.com/botble/cms/news/lock-660x330.jpg',
                'created_at' => '2018-04-13 05:40:18',
                'updated_at' => '2018-04-13 05:40:18',
            ),
            2 => 
            array (
                'id' => 3,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 49,
                'user_id' => 1,
                'key' => 'featured',
                'old_value' => '0',
                'new_value' => '1',
                'created_at' => '2018-04-13 05:41:32',
                'updated_at' => '2018-04-13 05:41:32',
            ),
            3 => 
            array (
                'id' => 4,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 50,
                'user_id' => 1,
                'key' => 'featured',
                'old_value' => '0',
                'new_value' => '1',
                'created_at' => '2018-04-13 05:42:27',
                'updated_at' => '2018-04-13 05:42:27',
            ),
            4 => 
            array (
                'id' => 5,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 54,
                'user_id' => 1,
                'key' => 'featured',
                'old_value' => '1',
                'new_value' => '0',
                'created_at' => '2018-04-13 06:04:12',
                'updated_at' => '2018-04-13 06:04:12',
            ),
            5 => 
            array (
                'id' => 6,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 54,
                'user_id' => 1,
                'key' => 'featured',
                'old_value' => '0',
                'new_value' => '1',
                'created_at' => '2018-04-13 06:04:20',
                'updated_at' => '2018-04-13 06:04:20',
            ),
            6 => 
            array (
                'id' => 7,
                'revisionable_type' => 'Modules\\Page\\Models\\Page',
                'revisionable_id' => 17,
                'user_id' => 1,
                'key' => 'description',
                'old_value' => 'Đây là trang liên hệ',
                'new_value' => NULL,
                'created_at' => '2020-03-10 15:33:16',
                'updated_at' => '2020-03-10 15:33:16',
            ),
            7 => 
            array (
                'id' => 8,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 53,
                'user_id' => 1,
                'key' => 'name',
                'old_value' => 'Hành trình tìm kiếm sự khác biệt',
                'new_value' => 'Apple iMac with Retina 5K display review',
                'created_at' => '2020-04-06 21:23:48',
                'updated_at' => '2020-04-06 21:23:48',
            ),
            8 => 
            array (
                'id' => 9,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 53,
                'user_id' => 1,
                'key' => 'description',
                'old_value' => 'Hành trình tìm kiếm sự khác biệt',
                'new_value' => 'Don’t act so surprised, Your Highness. You weren’t on any mercy mission this time. Several transmissions were beamed to this ship by Rebel spies. I want to know what happened to the plans they sent you. In my experience, there is no such thing as luck.',
                'created_at' => '2020-04-06 21:23:48',
                'updated_at' => '2020-04-06 21:23:48',
            ),
            9 => 
            array (
                'id' => 10,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 46,
                'user_id' => 1,
                'key' => 'name',
                'old_value' => 'Bạn sẽ chọn công ty nào',
                'new_value' => '10,000 Web Site Visitors In One Month:Guaranteed',
                'created_at' => '2020-04-06 21:25:08',
                'updated_at' => '2020-04-06 21:25:08',
            ),
            10 => 
            array (
                'id' => 11,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 46,
                'user_id' => 1,
                'key' => 'description',
                'old_value' => 'Đây là bài viết mẫu, nội dung của những bài viết demo đều giống nhau, nó được dùng với mục đích làm ví dụ, các bài viết hiện tại trên trang demo đều có nội dung giống nhau về phần nội dung và mô tả ngắn.',
                'new_value' => 'Don’t act so surprised, Your Highness. You weren’t on any mercy mission this time. Several transmissions were beamed to this ship by Rebel spies. I want to know what happened to the plans they sent you. In my experience, there is no such thing as luck.',
                'created_at' => '2020-04-06 21:25:08',
                'updated_at' => '2020-04-06 21:25:08',
            ),
            11 => 
            array (
                'id' => 12,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 51,
                'user_id' => 1,
                'key' => 'name',
                'old_value' => 'Sản phẩm trí tuệ Việt Nam',
                'new_value' => 'Unlock The Secrets Of Selling High Ticket Items',
                'created_at' => '2020-04-06 21:25:59',
                'updated_at' => '2020-04-06 21:25:59',
            ),
            12 => 
            array (
                'id' => 13,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 51,
                'user_id' => 1,
                'key' => 'description',
                'old_value' => 'Mô tả',
                'new_value' => 'Don’t act so surprised, Your Highness. You weren’t on any mercy mission this time. Several transmissions were beamed to this ship by Rebel spies. I want to know what happened to the plans they sent you. In my experience, there is no such thing as luck.',
                'created_at' => '2020-04-06 21:25:59',
                'updated_at' => '2020-04-06 21:25:59',
            ),
            13 => 
            array (
                'id' => 14,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 49,
                'user_id' => 1,
                'key' => 'name',
                'old_value' => 'Nền tảng mã nguồn mở PHP',
                'new_value' => 'Simple Ways To Reduce Your Unwanted Wrinkles!',
                'created_at' => '2020-04-06 21:27:06',
                'updated_at' => '2020-04-06 21:27:06',
            ),
            14 => 
            array (
                'id' => 15,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 49,
                'user_id' => 1,
                'key' => 'description',
                'old_value' => 'Nền tảng',
                'new_value' => 'Don’t act so surprised, Your Highness. You weren’t on any mercy mission this time. Several transmissions were beamed to this ship by Rebel spies.',
                'created_at' => '2020-04-06 21:27:06',
                'updated_at' => '2020-04-06 21:27:06',
            ),
            15 => 
            array (
                'id' => 16,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 53,
                'user_id' => 1,
                'key' => 'image',
                'old_value' => 'news/1476891195-02.jpg',
                'new_value' => 'news/1476893532-01.jpg',
                'created_at' => '2020-04-07 03:09:44',
                'updated_at' => '2020-04-07 03:09:44',
            ),
            16 => 
            array (
                'id' => 17,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 53,
                'user_id' => 1,
                'key' => 'image',
                'old_value' => 'news/1476893532-01.jpg',
                'new_value' => 'news/1476890031-hero02.jpg',
                'created_at' => '2020-04-07 03:10:52',
                'updated_at' => '2020-04-07 03:10:52',
            ),
            17 => 
            array (
                'id' => 18,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 49,
                'user_id' => 1,
                'key' => 'image',
                'old_value' => 'news/7998125906-4489ed8a2f-b-660x330.jpg',
                'new_value' => 'news/4381851322-d46fd7d75e-b-660x330.jpg',
                'created_at' => '2020-04-07 03:12:37',
                'updated_at' => '2020-04-07 03:12:37',
            ),
            18 => 
            array (
                'id' => 19,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 49,
                'user_id' => 1,
                'key' => 'image',
                'old_value' => 'news/4381851322-d46fd7d75e-b-660x330.jpg',
                'new_value' => 'news/7998125906-4489ed8a2f-b-660x330.jpg',
                'created_at' => '2020-04-07 03:12:53',
                'updated_at' => '2020-04-07 03:12:53',
            ),
            19 => 
            array (
                'id' => 20,
                'revisionable_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'revisionable_id' => 49,
                'user_id' => 1,
                'key' => 'image',
                'old_value' => 'news/7998125906-4489ed8a2f-b-660x330.jpg',
                'new_value' => 'news/7998125906-4489ed8a2f-b.jpg',
                'created_at' => '2020-04-07 03:14:08',
                'updated_at' => '2020-04-07 03:14:08',
            ),
        ));

        
    }
}