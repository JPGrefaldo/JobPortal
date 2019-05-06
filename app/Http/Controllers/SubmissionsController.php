<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectJob;
use Illuminate\Http\Request;

class SubmissionsController extends Controller
{
    public function show(Project $project, ProjectJob $job)
    {
        $job = $job->load('pay_type', 'position');
        $submissions = $job->submissions()
                            ->with(['crew' => function($q){
                                $q->with('user');
                            }])
                            ->get()
                            ->sortByDesc('approve_at');
        
        return view('projects.submissions', compact('project', 'job', 'submissions'));
    }
}