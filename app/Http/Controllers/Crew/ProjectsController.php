<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;

class ProjectsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $crew = $user->crew;

        $projects = $crew->projects;

        return $projects;
    }
}
