<?php

use App\Models\ProjectJob;
use App\Models\Submission;
use App\Models\User;

$factory->define(Submission::class, function () {
    return [
        'crew_id'        => factory(User::class),
        'project_job_id' => factory(ProjectJob::class),
    ];
});
