<?php

namespace App\Actions\Submissions;

use App\Models\Submission;
use Carbon\Carbon;

class SetSubmissionStatus
{
    public function execute(Submission $submission, $toReset, $toSet): Submission
    {
        if (! empty($submission->$toReset)) {
            $submission->$toReset = null;
        }

        $submission->$toSet = Carbon::now();
        $submission->save();

        return $submission;
    }
}