<?php

namespace App\Actions\Submissions;

use App\Models\Crew;
use App\Models\ProjectJob;
use App\Models\Submission;

class StoreSubmission
{
    /**
     * @param \App\Models\Crew $crew
     * @param \App\Models\ProjectJob $job
     * 
     * @return \App\Models\Submission
     */
    public function execute(Crew $crew, ProjectJob $job, String $note): Submission
    {
        $submission = $job->submissions()->create([
            'crew_id'     => $crew->id,
            'project_id'  => $job->project_id,
        ]);

        $submission->note()->create([
            'body' => $note
        ]);

        return $submission;
    }
}
