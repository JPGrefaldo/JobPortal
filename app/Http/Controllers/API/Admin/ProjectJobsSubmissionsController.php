<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\ProjectJob;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\ProjectJobsSubmissionsRequest;
use App\Actions\Admin\CreateProjectJobsSubmission;

class ProjectJobsSubmissionsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(
            [
                'message'    => 'Sucessfully fetched job\'s submissions',
                'projectJob' => ProjectJob::find($request->job)
                    ->with('submissions')
                    ->get()
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProjectJobsSubmissionsRequest $request)
    {
        $data = app(CreateProjectJobsSubmission::class)->execute($request);

        return response()->json(
            [
                'message'    => 'Submission successfully added',
                'projectJob' => ProjectJob::find($data->project_job_id)
                    ->with('submissions')
                    ->get()
            ],
            Response::HTTP_CREATED
        );
    }
}
