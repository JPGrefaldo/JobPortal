<?php

use App\Models\Role;
use App\Utils\StrUtils;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(\App\Models\UserNotificationSetting::class, function (Faker $faker) {
    return [
        'user_id'                    => function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'receive_email_notification' => 1,
        'receive_other_emails'       => 1,
        'receive_sms'                => 1,
    ];
});