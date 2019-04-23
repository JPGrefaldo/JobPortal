<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProjectJob;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubmissionsController extends Controller
{
    public function index(ProjectJob $job)
    {
        return response()->json(
            [
                'message'       => 'Sucessfully fetched job\'s submissions',
                'job'           => $job,
                'submissions'   => $job->submissions
            ],
            Response::HTTP_OK
        );
    }

    public function store(ProjectJob $job)
    {
        $crew = auth()->user()->crew;
        $job->submissions()->create(
            [
                'crew_id' => $crew->id
            ]
        );

        return response()->json(
            [
                'message'       => 'Submission successfully added',
                'submissions'   => $job->submissions
            ],
            Response::HTTP_CREATED
        );
    }
}
