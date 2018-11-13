<?php

use App\Models\Crew;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(App\Models\CrewProject::class, function (Faker $faker) {
    return [
        'crew_id' => factory(Crew::class)->create()->id,
        'project_id' => factory(Project::class)->create()->id,
    ];
});
