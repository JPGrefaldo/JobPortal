<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\CreateProjectJobRequest;
use App\Http\Requests\Producer\UpdateProjectJobRequest;
use App\Models\ProjectJob;
use App\Services\Producer\ProjectJobsService;

class ProjectJobsController extends Controller
{
    /**
     * @param \App\Http\Requests\Producer\CreateProjectJobRequest $request
     */
    public function store(CreateProjectJobRequest $request)
    {
        $input = $request->validated();

        app(ProjectJobsService::class)->create($input);
    }

    /**
     * @param \App\Http\Requests\Producer\UpdateProjectJobRequest $request
     * @param \App\Models\ProjectJob $job
     */
    public function update(UpdateProjectJobRequest $request, ProjectJob $job)
    {
        $input = $request->validated();

        app(ProjectJobsService::class)->update($input, $job);
    }
}
