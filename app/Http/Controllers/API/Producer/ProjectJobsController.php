<?php

namespace App\Http\Controllers\API\Producer;

use App\Actions\Producer\Project\CreateProjectJob;
use App\Actions\Producer\Project\UpdateProjectJob;
use App\Models\ProjectJob;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ProjectJobsController extends Controller
{
    public function store(Request $request)
    {
        $job = app(CreateProjectJob::class)->execute($request->all());

        return response()->json([
                'message' => 'Sucessfully added the project\'s job',
                'job' => $job->load('position')
            ],
            Response::HTTP_CREATED
        );
    }

    public function update(ProjectJob $projectJob, Request $request)
    {
        $job = app(UpdateProjectJob::class)->execute($projectJob, $request->toArray());
        
        return response()->json([
                'message' => 'Sucessfully added the project\'s job',
                'job' => $job->load('position')
            ],
            Response::HTTP_OK
        );
    }

    public function destroy(ProjectJob $projectJob)
    {
        $projectJob->delete();
        return response()->json(Response::HTTP_NO_CONTENT);
    }
}
