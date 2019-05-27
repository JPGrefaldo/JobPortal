<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ThreadResource;
use App\Models\Project;

class ThreadController extends Controller
{
    public function index(Project $project)
    {
        $user    = auth()->user();
        $threads = $user->projects()
                        ->find($project->id)
                        ->threads()
                        ->latest('updated_at')
                        ->get();

        return ThreadResource::collection($threads);
    }
}
