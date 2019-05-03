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
            $submission->crew
                        ->submissionCount = Submission::where(
                            [
                                'crew_id'    => $submission->crew->id,
                                'project_id' => $project->id
                            ]
                        )->count();
        });
        
        return view('projects.submissions', compact('project', 'job', 'submissions'));
    }
}