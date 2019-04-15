<?php

use Illuminate\Support\Str;
use App\Faker\PhoneProvider;
use App\Models\User;
use App\Utils\StrUtils;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(User::class, function (Faker $faker) {
    $faker->addProvider(new PhoneProvider($faker));

    return [
        'first_name'     => $faker->unique()->firstName,
        'last_name'      => $faker->unique()->lastName,
        'email'          => $faker->unique()->safeEmail,
        'nickname'       => $faker->unique()->firstName. ' ' .$faker->unique()->lastName,
        'phone'          => StrUtils::stripNonNumeric($faker->unformattedPhoneNumber()),
        'password'       => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        'remember_token' => Str::random(10),
        'status'         => 1,
        'confirmed'      => 1,
    ];
});
