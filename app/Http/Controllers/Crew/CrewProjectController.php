<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\FetchJobByPosition;
use App\Http\Controllers\Controller;
use App\Models\Crew;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Response;

class CrewProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
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
        $projects = Project::has('jobs')->with(['jobs' => function ($q) {
            $q->withCount('submissions')->get();
        }, 'jobs.position', 'jobs.pay_type'])
            ->get();

        return view('projects.current-projects', compact('projects'));
    }

    public function jobs()
    {
        $crew = auth()->user()->crew;
        $jobs = app(FetchJobByPosition::class)->execute($crew);

        return view('crew.projects', compact('jobs'));
    }
}
