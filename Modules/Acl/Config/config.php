<?php

return [
    'name' => 'Acl',

    /*
    |--------------------------------------------------------------------------
    | Activations
    |--------------------------------------------------------------------------
    |
    | Here you may specify the activations model used and the time (in seconds)
    | which activation codes expire. By default, activation codes expire after
    | three days. The lottery is used for garbage collection, expired
    | codes will be cleared automatically based on the provided odds.
    |
    */

    'activations' => [

        'expires' => 259200,

        'lottery' => [2, 100],

    ],

    'backgrounds' => [
        'vendor/core/images/backgrounds/1.jpg',
        'vendor/core/images/backgrounds/2.jpg',
        'vendor/core/images/backgrounds/3.jpg',
        'vendor/core/images/backgrounds/4.jpg',
        'vendor/core/images/backgrounds/5.jpg',
        'vendor/core/images/backgrounds/6.jpg',
        'vendor/core/images/backgrounds/7.jpg',
    ],
];
