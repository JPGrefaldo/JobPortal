<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\CreateProjectRequest;
use App\Services\Producer\ProjectsServices;

class ProjectsController extends Controller
{
    public function store(CreateProjectRequest $request)
    {
        $input   = $request->validated();
        $service = app(ProjectsServices::class);
        $project = $service->create($input, auth()->user());

        foreach ($input['jobs'] as $jobInput) {
            $service->createJob($jobInput, $project);
        }
    }
}
