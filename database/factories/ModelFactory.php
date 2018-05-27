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
            $path    = 'photos/' . $faker->uuid . '/' . $tmpFile->hashName();

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

$factory->define(\App\Models\ProjectType::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
    ];
});

$factory->define(\App\Models\Site::class, function (Faker $faker) {
    return [
        'name'               => $faker->domainWord,
        'hostname'           => $faker->domainName,
        'forward_to_site_id' => 0,
        'status'             => 1,
    ];
});

$factory->define(\App\Models\Project::class, function (Faker $faker) {
    return [
        'title'                  => $faker->words(3, true),
        'production_name'        => $faker->word(3, true),
        'production_name_public' => $faker->boolean,
        'project_type_id'        => function () {
            return factory(\App\Models\ProjectType::class)->create()->id;
        },
        'user_id'                => function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'site_id'                => function () {
            return factory(\App\Models\Site::class)->create()->id;
        },
        'description'            => $faker->sentence,
        'location'               => $faker->address,
        'status'                 => 0,
    ];
});

$factory->define(\App\Models\RemoteProject::class, function (Faker $faker) {
    return [
        'project_id' => function () {
            return factory(\App\Models\Project::class)->create()->id;
        },
        'site_id'    => function () {
            return factory(\App\Models\Project::class)->create()->id;
        },
    ];
});

$factory->define(\App\Models\PayType::class, function ($faker) {
    return [
        'name'     => $faker->word,
        'has_rate' => $faker->boolean,
    ];
});

$factory->define(\App\Models\ProjectJob::class, function (Faker $faker) {
    return [
        'persons_needed'       => $faker->numberBetween(1, 10),
        'dates_needed'         => $faker->date(),
        'pay_rate'             => $faker->randomFloat(2, 100),
        'notes'                => $faker->paragraph,
        'rush_call'            => $faker->boolean,
        'travel_expenses_paid' => $faker->boolean,
        'gear_provided'        => $faker->sentence,
        'gear_needed'          => $faker->sentence,
        'status'               => 0,
        'project_id'           => function () {
            return factory(\App\Models\Project::class)->create()->id;
        },
        'position_id'          => function () {
            return factory(\App\Models\Position::class)->create()->id;
        },
        'pay_type_id'          => function () {
            return factory(App\Models\PayType::class)->create()->id;
        },
    ];
});
