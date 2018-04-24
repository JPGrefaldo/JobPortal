<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    $faker->addProvider(new \App\Faker\PhoneProvider($faker));

    return [
        'uuid'           => $faker->uuid,
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'email'          => $faker->unique()->safeEmail,
        'phone'          => $faker->phoneNumber,
        'password'       => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'status'         => 1,
        'confirmed'      => 1,
    ];
});

$factory->define(App\Models\Crew::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'bio'     => $faker->sentence,
        'photo'   => 'photos/' . $faker->uuid . '/' . $faker->sha1 . '.png',
    ];
});

$factory->state(App\Models\Crew::class, 'Photo', function (Faker $faker) {
    return [
        'photo' => function () use ($faker) {
            $tmpPhoto = $faker->image();
            $path     = 'photos/' . $faker->uuid . '/' . basename($tmpPhoto);

            Storage::put($path, file_get_contents($tmpPhoto));
            unlink($tmpPhoto);

            return $path;
        },
    ];
});

$factory->define(App\Models\CrewReel::class, function (Faker $faker) {
    return [
        'crew_id' => function () {
            return factory(\App\Models\Crew::class)->create()->id;
        },
        'url'     => $faker->url,
        'general' => 1
    ];
});
