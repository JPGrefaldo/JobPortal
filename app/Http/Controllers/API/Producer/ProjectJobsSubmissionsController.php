<?php

namespace App\Http\Controllers\API\Producer;

use App\Models\ProjectJob;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\ProjectJobsSubmissionsRequest;

class ProjectJobsSubmissionsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            [
                'message'    => 'Sucessfully fetched job\'s submissions',
                'projectJob' => ProjectJob::find($request->job)->with('submissions')->get()
            ],
            Response::HTTP_OK
        );
    }

    public function store($id, ProjectJobsSubmissionsRequest $request)
    {
        $request->createSubmission();

        return response()->json(
            [
                'message'    => 'Submission successfully added',
                'projectJob' => ProjectJob::find($request->project_job_id)->with('submissions')->get()
            ],
            Response::HTTP_CREATED
        );
    }
}
