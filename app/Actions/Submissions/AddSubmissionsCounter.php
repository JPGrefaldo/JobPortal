<?php

namespace App\Actions\Submissions;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class AddSubmissionsCounter
{
    public function execute(Project $project, Collection $submissions): Collection
    {
        $submissions->map(function($submission) use($project){
            $submission_count = $submission->where(
                [
                    'crew_id'    => $submission->crew_id,
                    'project_id' => $project->id
                ]
            )->count();

            $submission->crew->submission_count = $submission_count;
        });

        return $submissions;
    }
}