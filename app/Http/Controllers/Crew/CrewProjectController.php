<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\Project;
use App\Models\User;

class CrewProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $biography = Crew::where('user_id', $user->id)->first();

        return view('projects.my-projects', compact('user', 'biography'));
    }

    public function showPostProject()
    {
        return view('projects.post-project');
    }

    public function showCurrentProjects()
    {
        $projects = Project::has('jobs')->with(['jobs', 'jobs.position', 'jobs.pay_type'])->get();

        return view('projects.current-projects', compact('projects'));
    }
}