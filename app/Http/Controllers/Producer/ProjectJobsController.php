<?php

namespace App\Http\Controllers\Producer;

use App\Http\Requests\Producer\UpdateProjectJobRequest;
use App\Models\ProjectJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectJobsController extends Controller
{
    public function update(UpdateProjectJobRequest $request, ProjectJob $job)
    {
        $input = $request->validated();
    }
}
