<?php

namespace Modules\Plugins\Location\Seeders;

use Artisan;
use Modules\Plugins\Language\Models\LanguageMeta;
use Modules\Plugins\Location\Models\City;
use Modules\Plugins\Location\Models\Country;
use Modules\Plugins\Location\Models\State;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run()
    {
        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            LanguageMeta::whereIn('reference_type', [City::class, State::class, Country::class])->delete();
        }

        City::truncate();
        State::truncate();
        Country::truncate();

        $this->createDataForUs();
    }

    protected function createDataForUs()
    {
        Country::create([
            'id'          => 1,
            'name'        => 'United States of America',
            'nationality' => 'Americans',
            'is_default'  => 1,
            'status'      => 'published',
            'order'       => 0,
        ]);

        $states = file_get_contents(__DIR__ . '/../../database/files/us/states.json');
        $states = json_decode($states, true);
        foreach ($states as $state) {
            State::create($state);
        }

        $cities = file_get_contents(__DIR__ . '/../../database/files/us/cities.json');
        $cities = json_decode($cities, true);
        foreach ($cities as $item) {
            if (City::where('name', $item['fields']['city'])->count() > 0) {
                continue;
            }

            $state = State::where('abbreviation', $item['fields']['state_code'])->first();
            if (!$state) {
                continue;
            }

            $city = [
                'name'       => $item['fields']['city'],
                'state_id'   => $state->id,
                'country_id' => 1,
            ];
            City::create($city);
        }

        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            Artisan::call('cms:language:sync', ['table' => 'countries', 'reference' => Country::class]);
            Artisan::call('cms:language:sync', ['table' => 'states', 'reference' => State::class]);
            Artisan::call('cms:language:sync', ['table' => 'cities', 'reference' => City::class]);
        }
    }
}
