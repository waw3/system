<?php

namespace Modules\Plugins\Vendor\Seeders;

use Modules\Plugins\Vendor\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run()
    {
        Package::truncate();

        $data = [
            [
                'name' => 'Free First Post',
                'price' => 0,
                'currency_id' => 1,
                'percent_save' => 0,
                'order' => 0,
                'number_of_listings' => 1,
                'account_limit' => 1,
                'is_default' => false,
            ],
            [
                'name' => 'Single Post',
                'price' => 250,
                'currency_id' => 1,
                'percent_save' => 0,
                'order' => 0,
                'number_of_listings' => 1,
                'is_default' => true,
            ],
            [
                'name' => '5 Posts',
                'price'              => 1000,
                'currency_id'        => 1,
                'percent_save'       => 20,
                'order'              => 0,
                'number_of_listings' => 5,
                'is_default'         => false,
            ],
        ];

        foreach ($data as $item) {
            Package::create($item);
        }
    }
}
