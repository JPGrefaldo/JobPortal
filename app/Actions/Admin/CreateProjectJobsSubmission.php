<?php

namespace App\Actions\Admin;

use App\Http\Requests\Producer\ProjectJobsSubmissionsRequest;
use App\Models\Submission;

class CreateProjectJobsSubmission
{
    /**
     * @param \App\Http\Requests\Producer\ProjectJobsSubmissionsRequest $request
     * @return \App\Models\ProjectJob
     */
    public function execute(ProjectJobsSubmissionsRequest $request): Submission
    {
        return Submission::create([
            'project_job_id' => $request->project_job_id,
            'crew_id'        => $request->crew_id
        ]);
    }
}
