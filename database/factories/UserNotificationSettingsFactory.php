<?php

use App\Models\User;
use App\Models\UserNotificationSetting;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(UserNotificationSetting::class, function (Faker $faker) {
    return [
        'user_id'                    => factory(User::class),
        'receive_email_notification' => 1,
        'receive_other_emails'       => 1,
        'receive_sms'                => 1,
    ];
});
