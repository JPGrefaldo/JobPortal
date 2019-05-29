<?php

namespace App\Http\Controllers\API;

use App\Actions\Submissions\SetSubmissionStatus;
use App\Actions\Submissions\StoreSubmission;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmissionRequest;
use App\Models\ProjectJob;
use App\Models\Submission;
use Illuminate\Http\Response;


class SubmissionController extends Controller
{
    public function index(ProjectJob $job)
    {
        return response()->json(
            [
                'message'       => 'Sucessfully fetched job\'s submissions',
                'job'           => $job,
                'submissions'   => $job->submissions,
            ],
            Response::HTTP_OK
        );
    }

    public function fetchByApprovedDate(ProjectJob $projectJob)
    {
        $submissions = $projectJob->submissions()
            ->whereNotNull('approved_at')
            ->with(['crew' => function ($q) {
                $q->with('user');
            }])
            ->get();

        return response()->json(
            [
                'message'       => 'Sucessfully fetched job\'s submissions',
                'submissions'   => $submissions,
            ],
            Response::HTTP_OK
        );
    }

    public function store(ProjectJob $job, SubmissionRequest $request)
    {
        $crew = auth()->user()->crew;

        $submission = app(StoreSubmission::class)->execute($crew, $job, $request->note);

        return response()->json(
            [
                'message'       => 'Submission successfully added',
                'submission'   => $submission,
            ],
            Response::HTTP_CREATED
        );
    }

    public function approve(Submission $submission)
    {
        $submission = app(SetSubmissionStatus::class)->execute($submission, 'rejected_at', 'approved_at');

        return response()->json(
            [
                'message'    => 'Submission is successfully approved',
                'submission' => $submission,
            ],
            Response::HTTP_OK
        );
    }

    public function reject(Submission $submission)
    {
        $submission = app(SetSubmissionStatus::class)->execute($submission, 'approved_at', 'rejected_at');

        return response()->json(
            [
                'message'    => 'Submission is successfully rejected',
                'submission' => $submission,
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
                'submission' => $submission,
            ],
            Response::HTTP_OK
        );
    }

    public function swap(Submission $submissionToReject, Submission $submissionToApprove)
    {
        app(SetSubmissionStatus::class)->execute($submissionToReject, 'approved_at', 'rejected_at');
        $submission = app(SetSubmissionStatus::class)->execute($submissionToApprove, 'rejected_at', 'approved_at');

        return response()->json(
            [
                'message'    => 'Submission successfully swapped.',
                'submission' => $submission,
            ],
            Response::HTTP_OK
        );
    }
}
