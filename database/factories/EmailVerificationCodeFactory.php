<?php

use Faker\Generator as Faker;

$factory->define(App\Models\EmailVerificationCode::class, function (Faker $faker) {
    static $user_id;

    return [
        'user_id' => $user_id ?: function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'code' => $faker->uuid,
    ];
});
