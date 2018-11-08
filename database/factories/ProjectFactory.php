<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\ProjectType::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
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