<?php

namespace App\Http\Controllers\Producer;

use App\Http\Requests\Producer\UpdateProjectJobRequest;
use App\Models\ProjectJob;
use App\Services\Producer\ProjectJobsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectJobsController extends Controller
{
    /**
     * @param \App\Http\Requests\Producer\UpdateProjectJobRequest $request
     * @param \App\Models\ProjectJob                              $job
     */
    public function update(UpdateProjectJobRequest $request, ProjectJob $job)
    {
        $input = $request->validated();

        app(ProjectJobsService::class)->update($input, $job);
    }
}
