<?php

namespace App\Http\Controllers\API\Crew;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;

class ProjectsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $crew = $user->crew;
        $projects = $crew->projects->paginate();

        return ProjectResource::collection($projects);
    }
}
