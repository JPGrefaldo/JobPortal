<?php

use App\Models\Crew;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(Crew::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'bio'     => $faker->sentence,
        'photo'   => 'photos/' . $faker->uuid . '/' . $faker->sha1 . '.png',
    ];
});

$factory->state(Crew::class, 'PhotoUpload', function (Faker $faker) {
    return [
        'photo' => function () use ($faker) {
            $tmpFile = UploadedFile::fake()->image($faker->sha1 . '.png');
            $path = 'photos/' . $faker->uuid . '/' . $tmpFile->hashName();

            Storage::put($path, file_get_contents($tmpFile));

            return $path;
        },
    ];
});
