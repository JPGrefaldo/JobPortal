<?php

use App\Models\Crew;
use App\Models\CrewIgnoredJobs;
use App\Models\ProjectJob;
use Faker\Generator as Faker;

$factory->define(CrewIgnoredJobs::class, function(Faker $faker) {
    return [
        'crew_id'        => factory(Crew::class),
        'project_job_id' => factory(ProjectJob::class)
    ];
});