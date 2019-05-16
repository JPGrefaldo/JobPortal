<?php

namespace App\Http\Controllers\Crew;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProjectJob;

class ProjectJobController extends Controller
{
    public function show(ProjectJob $projectJob)
    {
        //TODO: View for showing the job
        return $projectJob;
    }

    public function checkSubmission(ProjectJob $projectJob)
    {
        $crew = auth()->user()->crew;

        return $crew->submissions->firstOrFail([
            'project_id'     => $projectJob->project_id,
            'project_job_id' => $projectJob->id,
        ]);
    }
}
