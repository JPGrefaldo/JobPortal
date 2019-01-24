<?php

namespace App\Http\Controllers\API\Producer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;

class ProjectsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $projects = $user->projects->paginate();

        return ProjectResource::collection($projects);
    }
}
