<?php

namespace App\Http\Controllers\API\Crew;

use App\Actions\Crew\FetchJobByPosition;
use App\Http\Controllers\Controller;
use App\Models\ProjectJob;
use Illuminate\Http\Response;

class ProjectJobController extends Controller
{
    public function ignore(ProjectJob $job)
    {
        $crew = auth()->user()->crew;
        $crew->ignoredJobs()->create([
            'project_job_id' => $job->id
        ]);

        return response()->json([
            'message' => 'Successfully ignored the job'
            ],Response::HTTP_OK 
        );
    }

    public function unignore(ProjectJob $job)
    {
        $crew = auth()->user()->crew;
        $crew->unignoreJob($job);

        return response()->json([
            'message' => 'Successfully unignored the job'
            ],Response::HTTP_OK 
        );
    }

    public function ignored()
    {
        $crew = auth()->user()->crew;
        $jobs = app(FetchJobByPosition::class)->execute($crew, 'ignored');

        return response()->json([
                'message'   => 'Successfully fetched crew\'s ignored jobs',
                'jobs'      => $jobs
            ], Response::HTTP_OK
        );
    }
}
