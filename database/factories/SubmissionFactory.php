<?php

use App\Models\Crew;
use App\Models\ProjectJob;
use App\Models\Submission;

$factory->define(Submission::class, function () {
    return [
        'crew_id'        => factory(Crew::class),
        'project_job_id' => factory(ProjectJob::class),
        'approved_at'    => null,
        'rejected_at'    => null,
    ];
});
