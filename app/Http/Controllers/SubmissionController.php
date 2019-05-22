<?php

namespace App\Http\Controllers;

use App\Actions\Submissions\AddSubmissionsCounter;
use App\Actions\Submissions\FetchSubmissions;
use App\Models\Project;
use App\Models\ProjectJob;

class SubmissionController extends Controller
{
    public function show(Project $project, ProjectJob $job)
    {
        $job = $job->load('pay_type', 'position');

        $submissions = app(FetchSubmissions::class)->execute($job);
        $submissions = app(AddSubmissionsCounter::class)->execute($project, $submissions);

        return view('projects.submissions', compact('project', 'job', 'submissions'));
    }

    public function store(ProjectJob $job)
    {
        $crew = auth()->user()->crew;

        abort_unless($crew->hasGeneralResume(), 400, 'Please upload General Resume');

        $crew->submissions()->create([
            'project_id'     => $job->project_id,
            'project_job_id' => $job->id,
        ]);

        return response()->json([
            'message'        => 'success',
        ]);
    }

    public function checkSubmission(ProjectJob $job)
    {
        $crew = auth()->user()->crew;

        abort_unless($crew->hasAppliedTo($job), 404);

        return response()->json([
            'submitted' => 'true',
        ]);
    }
}
