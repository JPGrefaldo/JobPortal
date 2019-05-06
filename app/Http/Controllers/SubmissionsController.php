<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectJob;
use Illuminate\Http\Request;
use App\Models\Submission;

class SubmissionsController extends Controller
{
    public function show(Project $project, ProjectJob $job)
    {
        $job = $job->load('pay_type', 'position');
        $submissions = $job->submissions()
                            ->with(['crew' => function($q){
                                $q->with('user');
                            }])
                            ->get();

        $submissions->map(function($submission) use($project){
            $submission_count = Submission::where(
                [
                    'crew_id'    => $submission->crew_id,
                    'project_id' => $project->id
                ]
            )->count();

            $submission->crew->submission_count = $submission_count;
        });
        
        return view('projects.submissions', compact('project', 'job', 'submissions'));
    }
}