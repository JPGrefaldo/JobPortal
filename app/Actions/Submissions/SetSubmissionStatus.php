<?php

namespace App\Actions\Submissions;

use App\Models\Submission;
use Carbon\Carbon;

class SetSubmissionStatus
{
    /**
     * @param \App\Models\Submission $submission
     * @param $toReset
     * @param $toSet
     * @return \App\Models\Submission
     */
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
