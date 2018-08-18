<?php

use App\Models\Role;
use Faker\Generator as Faker;

$factory->define(App\Models\Crew::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\Models\User::class)->create()->id,
        'bio'     => $faker->sentence,
        'photo'   => 'photos/' . $faker->uuid . '/' . $faker->sha1 . '.png',
    ];
});

$factory->state(App\Models\Crew::class, 'PhotoUpload', function (Faker $faker) {
    return [
        'photo' => function () use ($faker) {
            $tmpFile = \Illuminate\Http\UploadedFile::fake()->image($faker->sha1 . '.png');
            $path    = 'photos/' . $faker->uuid . '/' . $tmpFile->hashName();

            Storage::put($path, file_get_contents($tmpFile));

            return $path;
        },
    ];
});

$factory->state(App\Models\Crew::class, 'withRole', function (Faker $faker) {
    return [
        'user_id' => function () use ($faker) {
            $user = factory(\App\Models\User::class)->create();
            $role = Role::where('name', Role::CREW)->first();
            $user->roles()->save($role);
            return $user->id;
        },
    ];
});
