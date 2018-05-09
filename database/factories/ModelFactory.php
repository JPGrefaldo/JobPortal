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

/** @var $factory \Illuminate\Database\Eloquent\Factory */

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

$factory->define(\App\Models\UserNotificationSetting::class, function (Faker $faker) {
    return [
        'user_id'                    => function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'receive_email_notification' => 1,
        'receive_other_emails'       => 1,
        'receive_sms'                => 1,
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

$factory->state(App\Models\Crew::class, 'PhotoUpload', function (Faker $faker) {
    return [
        'photo' => function () use ($faker) {
            $tmpFile = \Illuminate\Http\UploadedFile::fake()->image($faker->sha1 . '.png');
            $path     = 'photos/' . $faker->uuid . '/' . $tmpFile->hashName();

            Storage::put($path, file_get_contents($tmpFile));

            return $path;
        },
    ];
});

$factory->define(App\Models\CrewResume::class, function (Faker $faker) {
    return [
        'crew_id' => function () {
            return factory(\App\Models\Crew::class)->create()->id;
        },
        'url'     => 'resumes/' . $faker->uuid . '/' . $faker->sha1 . '.pdf',
        'general' => 1,
    ];
});

$factory->state(App\Models\CrewResume::class, 'Upload', function (Faker $faker) {
    return [
        'url' => function () use ($faker) {
            $tmpFile = \Illuminate\Http\UploadedFile::fake()->create($faker->sha1 . '.pdf');
            $path    = 'resumes/' . $faker->uuid . '/' . $tmpFile->hashName();

            Storage::put($path, file_get_contents($tmpFile));

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
        'general' => 1,
    ];
});

$factory->define(App\Models\CrewSocial::class, function (Faker $faker) {
    return [
        'crew_id'             => function () {
            return factory(\App\Models\Crew::class)->create()->id;
        },
        'url'                 => $faker->url,
        'social_link_type_id' => 1,
    ];
});

$factory->define(\App\Models\Department::class, function (Faker $faker) {
    return [
        'name'        => $faker->words(2, true),
        'description' => $faker->sentence,
    ];
});

$factory->define(\App\Models\Position::class, function (Faker $faker) {
    return [
        'name'          => $faker->words(2, true),
        'department_id' => function () {
            return factory(\App\Models\Department::class)->create()->id;
        },
        'has_gear'      => 0,
        'has_union'     => 0,
    ];
});
