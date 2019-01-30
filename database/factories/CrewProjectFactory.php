<?php

use App\Models\Crew;
use App\Models\CrewProject;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(CrewProject::class, function (Faker $faker) {
    return [
        'crew_id' => factory(Crew::class),
        'project_id' => factory(Project::class),
    ];
});
