<?php

use App\Models\EmailVerificationCode;
use App\Models\User;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(EmailVerificationCode::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'code'    => $faker->uuid,
    ];
});
