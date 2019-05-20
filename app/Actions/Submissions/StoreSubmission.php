<?php

namespace App\Actions\Submissions;

use App\Models\Crew;
use App\Models\ProjectJob;

class StoreSubmission
{
    /**
     * @param \App\Models\Crew $crew
     * @param \App\Models\ProjectJob $job
     * @return \App\Models\ProjectJob
     */
    public function execute(Crew $crew, ProjectJob $job): ProjectJob
    {
        $job->submissions()->create([
            'crew_id'     => $crew->id,
            'project_id'  => $job->project_id,
        ]);

        return $job;
    }
}
