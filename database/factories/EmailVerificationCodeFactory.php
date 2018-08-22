<?php

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(App\Models\EmailVerificationCode::class, function (Faker $faker) {
    return [
        'code' => $faker->uuid,
    ];
});

$factory->state(App\Models\EmailVerificationCode::class, 'withUser', function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
    ];
});
