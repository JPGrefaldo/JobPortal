<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\CreateProjectRequest;
use App\Http\Requests\Producer\UpdateProjectRequest;
use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Site;
use App\Services\Producer\ProjectsServices;
use App\Utils\UrlUtils;

class ProjectsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $projects = $user->projects;

        return $projects;
    }

    public function create()
    {
        $user = auth()->user();
        $projectTypes = ProjectType::all();
        $departments = Department::with('positions')->has('positions')->get();
        $hostname = UrlUtils::getHostNameFromBaseUrl(request()->getHttpHost());
        $sites = Site::where('hostname', '!=', $hostname)->get();

        return view('producer.projects.create', compact(
            'user',
            'projectTypes',
            'departments',
            'sites'
        ));
    }
    /**
     * @param \App\Http\Requests\Producer\CreateProjectRequest $request
     */
    public function store(CreateProjectRequest $request)
    {
        $input = $request->validated();

        app(ProjectsServices::class)->create(
            $input,
            auth()->user(),
            session('site')
        );
    }

    /**
     * @param \App\Http\Requests\Producer\UpdateProjectRequest $request
     * @param \App\Models\Project $project
     *
     * @throws \Exception
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $input = $request->validated();

        app(ProjectsServices::class)->update(
            $input,
            $project,
            session('site')
        );
    }
}
