<?php

use App\Models\Project;
use App\Models\RemoteProject;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(RemoteProject::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class),
        'site_id'    => factory(Project::class),
    ];
});
