<?php

namespace App\Actions\Admin;

use App\Http\Requests\Producer\ProjectJobsSubmissionsRequest;
use App\Models\Submission;

class StoreProjectJobsSubmission
{
    /**
     * @param ProjectJobsSubmissionsRequest $request
     * @return Submission
     */
    public function execute(ProjectJobsSubmissionsRequest $request): Submission
    {
        return Submission::create([
            'project_job_id' => $request->project_job_id,
            'crew_id'        => $request->crew_id,
            'project_id'     => $request->project_id,
        ]);
    }
}
