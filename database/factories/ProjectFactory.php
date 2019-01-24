<?php

use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Site;
use App\Models\User;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title'                  => $faker->company,
        'production_name'        => $faker->unique()->word(3, true),
        'production_name_public' => $faker->boolean,
        'project_type_id'        => factory(ProjectType::class),
        'user_id'                => factory(User::class),
        'site_id'                => factory(Site::class),
        'description'            => $faker->unique()->sentence,
        'location'               => $faker->unique()->address,
        'status'                 => 0,
    ];
});
