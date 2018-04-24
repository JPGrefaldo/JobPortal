<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;

$factory->define(App\Models\Crew::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'bio'     => $faker->sentence,
        'photo'   => 'photos/' . $faker->uuid . '/' . $faker->sha1 . '.png'
    ];
});

$factory->state(App\Models\Crew::class, 'Photo', function (Faker $faker) {
    return [
        'photo'   => function () use ($faker) {
            $tmpPhoto = $faker->image();
            $path     = 'photos/' . $faker->uuid . '/' . basename($tmpPhoto);

            Storage::put($path, file_get_contents($tmpPhoto));
            unlink($tmpPhoto);

            return $path;
        },
    ];
});
