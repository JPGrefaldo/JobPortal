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
use App\Models\RemoteProject;

class ProjectsController extends Controller
{
    public function index()
    {
        return view('producer.projects.my-projects');
    }

    public function create()
    {
        return view('producer.projects.create', $this->loadViewData());
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
    
    public function edit(Project $project)
    {
        return view(
            'producer.projects.edit', 
            $this->loadViewData(
                $project->load([
                    'remotes',
                    'jobs' => function($query){
                        $query->with('position');
                    }
                ])
            )
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

    private function loadViewData($project = null)
    {
        $user = auth()->user();
        $projectTypes = ProjectType::all();
        $departments = Department::with('positions')->has('positions')->get();
        $hostname = UrlUtils::getHostNameFromBaseUrl(request()->getHttpHost());
        $sites = Site::where('hostname', '!=', $hostname)->get();

        if($project === null){
            return compact(
                'user',
                'projectTypes',
                'departments',
                'sites'
            );
        }

        return compact(
            'user',
            'projectTypes',
            'departments',
            'project',
            'sites'
        );
    }
}
