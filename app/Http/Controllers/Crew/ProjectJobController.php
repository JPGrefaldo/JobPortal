<?php

namespace App\Http\Controllers\Crew;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProjectJob;

class ProjectJobController extends Controller
{
    public function show(ProjectJob $projectJob)
    {
        //TODO: View for showing the job
        return $projectJob;
    }
}
