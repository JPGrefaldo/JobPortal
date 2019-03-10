<?php

namespace App\Http\Controllers\API\Producer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\ProjectType;

class ProjectsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $projects = $user->projects->paginate();

        return ProjectResource::collection($projects);
    }

    public function projectType()
    {
        $types = ProjectType::all();

        return response()->json([
            'projectType' => $types
        ]);
    }
}
