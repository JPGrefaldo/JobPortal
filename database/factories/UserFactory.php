<?php

use App\Faker\PhoneProvider;
use App\Models\Role;
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
        'remember_token' => str_random(10),
        'status'         => 1,
        'confirmed'      => 1,
    ];
});

$factory
    ->state(User::class, 'withProducerRole', [])
    ->afterCreatingState(User::class, 'withProducerRole', function ($user, $faker) {
        $user->roles()->attach(Role::where('name', Role::PRODUCER)->first());
    });

// TODO: consider creating crew model connected to the user
$factory
    ->state(User::class, 'withCrewRole', [])
    ->afterCreatingState(User::class, 'withCrewRole', function ($user, $faker) {
        $user->roles()->attach(Role::where('name', Role::CREW)->first());
    });

$factory
    ->state(User::class, 'withAdminRole', [])
    ->afterCreatingState(User::class, 'withAdminRole', function ($user, $faker) {
        $user->roles()->attach(Role::where('name', Role::ADMIN)->first());
    });
