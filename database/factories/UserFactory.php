<?php

use App\Models\Role;
use App\Utils\StrUtils;
use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    $faker->addProvider(new \App\Faker\PhoneProvider($faker));

    return [
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'email'          => $faker->unique()->safeEmail,
        'phone'          => StrUtils::stripNonNumeric($faker->unformattedPhoneNumber()),
        'password'       => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'status'         => 1,
        'confirmed'      => 1,
    ];
});

$factory
    ->state(App\Models\User::class, 'withCrewRole', [])
    ->afterCreatingState(App\Models\User::class, 'withCrewRole', function ($user, $faker) {
        $user->roles()->attach(Role::where('name', Role::CREW)->first());
    });

$factory
    ->state(App\Models\User::class, 'withProducerRole', [])
    ->afterCreatingState(App\Models\User::class, 'withProducerRole', function ($user, $faker) {
        $user->roles()->attach(Role::where('name', Role::PRODUCER)->first());
    });
