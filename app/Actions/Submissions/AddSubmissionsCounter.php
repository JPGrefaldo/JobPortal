<?php

namespace App\Actions\Submissions;

use App\Models\Submission;

class AddSubmissionsCounter
{
    public function execute(Submission $submissions, Project $project): Submission
    {
        return $submissions->map(function($submission) use($project){
                    $submission->crew
                                ->submissionCount = Submission::where(
                                    [
                                        'crew_id'    => $submission->crew->id,
                                        'project_id' => $project->id
                                    ]
                                )->count();
                });
    }
}