<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\CreateProjectRequest;
use App\Http\Requests\Producer\UpdateProjectRequest;
use App\Models\Project;
use App\Services\Producer\ProjectsServices;

class ProjectsController extends Controller
{
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
