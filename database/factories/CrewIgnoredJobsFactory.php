<?php

use App\Models\Crew;
use App\Models\CrewIgnoredJob;
use App\Models\ProjectJob;
use Faker\Generator as Faker;

$factory->define(CrewIgnoredJob::class, function(Faker $faker) {
    return [
        'crew_id'        => factory(Crew::class),
        'project_job_id' => factory(ProjectJob::class)
    ];
});