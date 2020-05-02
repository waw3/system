<?php

use Modules\Member\Notifications\ConfirmEmailNotification;

return [
    'name' => 'Member',

    /*
    |--------------------------------------------------------------------------
    | Notification
    |--------------------------------------------------------------------------
    |
    | This is the notification class that will be sent to users when they receive
    | a confirmation code.
    |
    */
    'notification' => ConfirmEmailNotification::class,

    'verify_email' => env('CMS_MEMBER_VERIFY_EMAIL', true),
];
