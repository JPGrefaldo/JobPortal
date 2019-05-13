<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectJob;
use Illuminate\Http\Request;
use App\Models\Submission;
use App\Actions\Submissions\AddSubmissionsCounter;

class SubmissionController extends Controller
{
    public function show(Project $project, ProjectJob $job)
    {
        $job = $job->load('pay_type', 'position');
        $submissions = $job->submissions()
                            ->with(['crew' => function($q){
                                $q->with('user');
                            }])
                            ->orderByDesc('approve_at')
                            ->get();

        $submissions = app(AddSubmissionsCounter::class)->execute($project, $submissions);

        return view('projects.submissions', compact('project', 'job', 'submissions'));
    }
}
