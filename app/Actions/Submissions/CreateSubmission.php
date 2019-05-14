<?php

namespace App\Actions\Submissions;

use App\Models\Crew;
use App\Models\ProjectJob;

class CreateSubmission
{
    public function execute(Crew $crew, ProjectJob $job): ProjectJob
    {
        $job->submissions()->create([
            'crew_id'     => $crew->id,
            'project_id'  => $job->project_id
        ]);

        return $job;
    }
}
