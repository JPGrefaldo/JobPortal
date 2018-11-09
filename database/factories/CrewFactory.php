<?php

use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(App\Models\Crew::class, function (Faker $faker) {
    static $user_id;

    return [
        'user_id' => $user_id ?: function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'bio'     => $faker->sentence,
        'photo'   => 'photos/' . $faker->uuid . '/' . $faker->sha1 . '.png',
    ];
});

$factory->state(App\Models\Crew::class, 'PhotoUpload', function (Faker $faker) {
    return [
        'photo' => function () use ($faker) {
            $tmpFile = \Illuminate\Http\UploadedFile::fake()->image($faker->sha1 . '.png');
            $path = 'photos/' . $faker->uuid . '/' . $tmpFile->hashName();

            Storage::put($path, file_get_contents($tmpFile));

            return $path;
        },
    ];
});
