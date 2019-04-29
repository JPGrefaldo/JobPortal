<?php

namespace App\Http\Controllers\API\Producer;

use App\Http\Controllers\Controller;
use App\Models\ProjectJob;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

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
}
