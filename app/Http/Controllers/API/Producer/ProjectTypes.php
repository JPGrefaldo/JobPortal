<?php

namespace App\Http\Controllers\API\Producer;

use App\Http\Controllers\Controller;
use App\Models\ProjectType;

class ProjectTypes extends Controller
{
    public function index()
    {
        $types = ProjectType::all();

        return response()->json([
            'projectType' => $types
        ]);
    }
}
