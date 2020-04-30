<?php

use Illuminate\Database\Seeder;

class LanguageMetaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('language_meta')->delete();
        
        DB::table('language_meta')->insert(array (
            0 => 
            array (
                'lang_meta_id' => 3,
                'reference_id' => 4,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => 'a9d40e38f773df46bfe3857c89404a5f',
            ),
            1 => 
            array (
                'lang_meta_id' => 4,
                'reference_id' => 5,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '9cf3508b0becc5829411b251ab1d7d68',
            ),
            2 => 
            array (
                'lang_meta_id' => 5,
                'reference_id' => 6,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '14ea2c977bff486d5d93caeeddb25433',
            ),
            3 => 
            array (
                'lang_meta_id' => 6,
                'reference_id' => 7,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '1e3d1a0e8a2d0b0a820f6fa5ff37913b',
            ),
            4 => 
            array (
                'lang_meta_id' => 7,
                'reference_id' => 8,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => 'efa2fcd9b0bc7221fc37de650db1095d',
            ),
            5 => 
            array (
                'lang_meta_id' => 8,
                'reference_id' => 9,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '5aa291a9490cf5a6b770e4ef67eecf51',
            ),
            6 => 
            array (
                'lang_meta_id' => 9,
                'reference_id' => 10,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => 'ddf6b2634ac599fca598c9f707d7e967',
            ),
            7 => 
            array (
                'lang_meta_id' => 10,
                'reference_id' => 11,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '0162b0f534be9b5c0de3a2c21ee12a22',
            ),
            8 => 
            array (
                'lang_meta_id' => 11,
                'reference_id' => 12,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '58d24bc8ca3ef58e26b6f5f2e97feb52',
            ),
            9 => 
            array (
                'lang_meta_id' => 13,
                'reference_id' => 14,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '6a95efc9f3493402f6edc17125a5f621',
            ),
            10 => 
            array (
                'lang_meta_id' => 14,
                'reference_id' => 19,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => 'be26223edcf68e5f63a1a6437ba0be15',
            ),
            11 => 
            array (
                'lang_meta_id' => 15,
                'reference_id' => 15,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '36292b94b5bc330e88721f87c05e3d1c',
            ),
            12 => 
            array (
                'lang_meta_id' => 16,
                'reference_id' => 16,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => 'e4bc15912ab7551f41dda75cab017005',
            ),
            13 => 
            array (
                'lang_meta_id' => 17,
                'reference_id' => 17,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '73bd326091a134d6eb79570db924bb3d',
            ),
            14 => 
            array (
                'lang_meta_id' => 18,
                'reference_id' => 18,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '77999a905526eb38febac6a1e0f1f5d9',
            ),
            15 => 
            array (
                'lang_meta_id' => 19,
                'reference_id' => 20,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '26af70c0ef781166972928bd181ab10b',
            ),
            16 => 
            array (
                'lang_meta_id' => 20,
                'reference_id' => 21,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '3856d68ccb4721e6432dcc1ee7001e20',
            ),
            17 => 
            array (
                'lang_meta_id' => 24,
                'reference_id' => 46,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => 'efa2fcd9b0bc7221fc37de650db1095d',
            ),
            18 => 
            array (
                'lang_meta_id' => 25,
                'reference_id' => 11,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Category',
                'lang_meta_origin' => '4703171c553ee525c3a5436c254619cf',
            ),
            19 => 
            array (
                'lang_meta_id' => 26,
                'reference_id' => 1,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Category',
                'lang_meta_origin' => 'ff750ed85cf1ac627f2b323889f78dd6',
            ),
            20 => 
            array (
                'lang_meta_id' => 27,
                'reference_id' => 6,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Category',
                'lang_meta_origin' => '5d21f76eddb6b3d536cb390f4cda77bc',
            ),
            21 => 
            array (
                'lang_meta_id' => 28,
                'reference_id' => 7,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Category',
                'lang_meta_origin' => 'cd22dfa504c9bf620938f913773df770',
            ),
            22 => 
            array (
                'lang_meta_id' => 29,
                'reference_id' => 8,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Category',
                'lang_meta_origin' => 'da650dfca58083229317df283b16fa02',
            ),
            23 => 
            array (
                'lang_meta_id' => 30,
                'reference_id' => 9,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Category',
                'lang_meta_origin' => 'faa61a3d1e5630da1dc2cdcb4f11b552',
            ),
            24 => 
            array (
                'lang_meta_id' => 31,
                'reference_id' => 10,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Category',
                'lang_meta_origin' => '55be2035a27da7bfcc8ed4aeab28f4f1',
            ),
            25 => 
            array (
                'lang_meta_id' => 32,
                'reference_id' => 5,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Tag',
                'lang_meta_origin' => 'f0698ed728cc9c18387840b72346e005',
            ),
            26 => 
            array (
                'lang_meta_id' => 33,
                'reference_id' => 6,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Tag',
                'lang_meta_origin' => 'e4ef34ee9099a01fcec8f45a79c5d4ba',
            ),
            27 => 
            array (
                'lang_meta_id' => 34,
                'reference_id' => 1,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Gallery\\Models\\Gallery',
                'lang_meta_origin' => 'b5956d5eec65f9edeb008fdd97771f3e',
            ),
            28 => 
            array (
                'lang_meta_id' => 35,
                'reference_id' => 2,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Gallery\\Models\\Gallery',
                'lang_meta_origin' => '4367a6d49e1eb6e5fb64d77052997e9c',
            ),
            29 => 
            array (
                'lang_meta_id' => 36,
                'reference_id' => 3,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Gallery\\Models\\Gallery',
                'lang_meta_origin' => '0cc8e19b35bb9b0a6b0b45d8a358ee6c',
            ),
            30 => 
            array (
                'lang_meta_id' => 37,
                'reference_id' => 4,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Gallery\\Models\\Gallery',
                'lang_meta_origin' => 'a2879f55a54f0e629851df6b48f61241',
            ),
            31 => 
            array (
                'lang_meta_id' => 38,
                'reference_id' => 5,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Gallery\\Models\\Gallery',
                'lang_meta_origin' => 'e6ceb4ae110f3d66f9444211a2ac8337',
            ),
            32 => 
            array (
                'lang_meta_id' => 39,
                'reference_id' => 6,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Gallery\\Models\\Gallery',
                'lang_meta_origin' => '9f2f8e1a4752378951cc1312b419c102',
            ),
            33 => 
            array (
                'lang_meta_id' => 40,
                'reference_id' => 1,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Menu\\Models\\Menu',
                'lang_meta_origin' => '19848c17b2e0b8fd374ae6f4741599c4',
            ),
            34 => 
            array (
                'lang_meta_id' => 41,
                'reference_id' => 3,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Menu\\Models\\Menu',
                'lang_meta_origin' => '5d79633980667117eaee456018277ad8',
            ),
            35 => 
            array (
                'lang_meta_id' => 42,
                'reference_id' => 7,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Menu\\Models\\Menu',
                'lang_meta_origin' => 'b1ae8e07383b5d47e821dac905c86e6d',
            ),
            36 => 
            array (
                'lang_meta_id' => 43,
                'reference_id' => 8,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Menu\\Models\\Menu',
                'lang_meta_origin' => '78d39e8989bebaa53bac83ff0fedc678',
            ),
            37 => 
            array (
                'lang_meta_id' => 44,
                'reference_id' => 9,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Menu\\Models\\Menu',
                'lang_meta_origin' => '33a202bdbd1d82470cc1837e85622c5e',
            ),
            38 => 
            array (
                'lang_meta_id' => 47,
                'reference_id' => 23,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Page\\Models\\Page',
                'lang_meta_origin' => '0bff9f3639cec70a3f65fc0149ad2b24',
            ),
            39 => 
            array (
                'lang_meta_id' => 48,
                'reference_id' => 1,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Page\\Models\\Page',
                'lang_meta_origin' => '3e971ce162e3737ae2b7af1e78c4bca2',
            ),
            40 => 
            array (
                'lang_meta_id' => 51,
                'reference_id' => 1,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Block\\Models\\Block',
                'lang_meta_origin' => '671424045986775272d0ceb6aab7139a',
            ),
            41 => 
            array (
                'lang_meta_id' => 58,
                'reference_id' => 12,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Category',
                'lang_meta_origin' => 'ff750ed85cf1ac627f2b323889f78dd6',
            ),
            42 => 
            array (
                'lang_meta_id' => 66,
                'reference_id' => 49,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '5aa291a9490cf5a6b770e4ef67eecf51',
            ),
            43 => 
            array (
                'lang_meta_id' => 68,
                'reference_id' => 51,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '0162b0f534be9b5c0de3a2c21ee12a22',
            ),
            44 => 
            array (
                'lang_meta_id' => 76,
                'reference_id' => 25,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Tag',
                'lang_meta_origin' => 'f5a7aacaa745d7b1df533180f61bab95',
            ),
            45 => 
            array (
                'lang_meta_id' => 78,
                'reference_id' => 53,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Plugins\\Blog\\Models\\Post',
                'lang_meta_origin' => '6a95efc9f3493402f6edc17125a5f621',
            ),
            46 => 
            array (
                'lang_meta_id' => 81,
                'reference_id' => 6,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Menu\\Models\\Menu',
                'lang_meta_origin' => '3deb9e726e379790dcb23e6b0cf26e8f',
            ),
            47 => 
            array (
                'lang_meta_id' => 82,
                'reference_id' => 2,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Menu\\Models\\MenuLocation',
                'lang_meta_origin' => 'b8c6f006a28da7585aef81e9405306bd',
            ),
            48 => 
            array (
                'lang_meta_id' => 83,
                'reference_id' => 3,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Menu\\Models\\MenuLocation',
                'lang_meta_origin' => '3e08298053dbd3ea6ae1a6673f14f305',
            ),
            49 => 
            array (
                'lang_meta_id' => 84,
                'reference_id' => 1,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Menu\\Models\\MenuLocation',
                'lang_meta_origin' => '9b3f18ba090b776d3bbac1b450c9ab6a',
            ),
            50 => 
            array (
                'lang_meta_id' => 85,
                'reference_id' => 18,
                'lang_meta_code' => 'en_US',
                'reference_type' => 'Modules\\Page\\Models\\Page',
                'lang_meta_origin' => '94e47060e17df460dbc63d7e881099b4',
            ),
        ));

        
    }
}