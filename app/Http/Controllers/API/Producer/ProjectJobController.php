<?php

namespace App\Http\Controllers\API\Producer;

use App\Actions\Producer\Project\StoreProjectJob;
use App\Actions\Producer\Project\UpdateProjectJob;
use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\CreateProjectJobRequest;
use App\Models\ProjectJob;
use Illuminate\Http\Response;

class ProjectJobController extends Controller
{
    public function index()
    {
        return response()->json(
            [
                'message' => 'Sucessfully fetch the project\'s jobs.',
                'jobs'    => ProjectJob::all(),
            ],
            Response::HTTP_OK
        );
    }

    public function store(CreateProjectJobRequest $request)
    {
        $job = app(StoreProjectJob::class)->execute($request);

        return response()->json(
            [
                'message' => 'Sucessfully added the project\'s job.',
                'job'     => $job->load('position'),
            ],
            Response::HTTP_CREATED
        );
    }

    public function update(ProjectJob $projectJob, CreateProjectJobRequest $request)
    {
        $job = app(UpdateProjectJob::class)->execute($projectJob, $request);

        return response()->json(
            [
                'message' => 'Sucessfully updated the project\'s job.',
                'job'     => $job->load('position'),
            ],
            Response::HTTP_OK
        );
    }

    public function destroy(ProjectJob $projectJob)
    {
        $projectJob->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
