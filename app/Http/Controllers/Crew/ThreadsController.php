<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;
use App\Http\Resources\ThreadResource;
use App\Models\Project;

class ThreadsController extends Controller
{
    // TODO: check ownership of project
    public function index(Project $project)
    {
        return ThreadResource::collection($project->threads);
    }
}
