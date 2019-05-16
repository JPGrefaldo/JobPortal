<?php

namespace App\Http\Controllers\API;

use App\Actions\Submissions\CreateSubmission;
use App\Http\Controllers\Controller;
use App\Models\ProjectJob;
use App\Models\Submission;
use Carbon\Carbon;
use Illuminate\Http\Response;

class SubmissionController extends Controller
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

        $job = app(CreateSubmission::class)->execute($crew, $job);

        return response()->json(
            [
                'message'       => 'Submission successfully added',
                'submissions'   => $job->submissions
            ],
            Response::HTTP_CREATED
        );
    }

    public function approve(Submission $submission)
    {
        if (! empty($submission->rejected_at)) {
            $submission->rejected_at = null;
        }

        $submission->approved_at = Carbon::now();
        $submission->save();

        return response()->json(
            [
                'message'    => 'Submission is successfully approved',
                'submission' => $submission
            ],
            Response::HTTP_OK
        );
    }

    public function reject(Submission $submission)
    {
        if (! empty($submission->approved_at)) {
            $submission->approved_at = null;
        }

        $submission->rejected_at = Carbon::now();
        $submission->save();

        return response()->json(
            [
                'message'    => 'Submission is successfully rejected',
                'submission' => $submission
            ],
            Response::HTTP_OK
        );
    }

    public function restore(Submission $submission)
    {
        if (! empty($submission->approved_at)) {
            $submission->approved_at = null;
        }

        if (! empty($submission->rejected_at)) {
            $submission->rejected_at = null;
        }

        $submission->save();

        return response()->json(
            [
                'message'    => 'Submission is successfully restored',
                'submission' => $submission
            ],
            Response::HTTP_OK
        );
    }
}
