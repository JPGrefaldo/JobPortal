<?php

namespace App\Http\Controllers;

use App\Actions\Submissions\AddSubmissionsCounter;
use App\Actions\Submissions\FetchSubmissions;
use App\Models\Project;
use App\Models\ProjectJob;

class SubmissionsController extends Controller
{
    public function show(Project $project, ProjectJob $job)
    {
        $job = $job->load('pay_type', 'position');

        $submissions = app(FetchSubmissions::class)->execute($job);
        $submissions = app(AddSubmissionsCounter::class)->execute($project, $submissions);

        return view('projects.submissions', compact('project', 'job', 'submissions'));
    }
}