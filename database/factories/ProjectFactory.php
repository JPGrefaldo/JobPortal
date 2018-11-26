<?php

use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(\App\Models\Project::class, function (Faker $faker) {
    return [
        'title'                  => $faker->unique()->words(3, true),
        'production_name'        => $faker->unique()->word(3, true),
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
        'description'            => $faker->unique()->sentence,
        'location'               => $faker->unique()->address,
        'status'                 => 0,
    ];
});
