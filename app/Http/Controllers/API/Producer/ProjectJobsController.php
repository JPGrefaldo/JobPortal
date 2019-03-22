<?php

namespace App\Http\Controllers\API\Producer;

use App\Actions\Producer\Project\CreateProjectJob;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectJobsController extends Controller
{
    public function store(Request $request)
    {
        $job = app(CreateProjectJob::class)->execute($request->all());

        return response()->json([
            'message' => 'Sucessfully added the project\'s job',
            'job' => $job->load('position')
        ]);
    }
}
