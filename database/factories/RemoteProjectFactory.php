<?php

use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

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