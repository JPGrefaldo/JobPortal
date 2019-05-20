<?php

namespace App\Actions\Submissions;

use App\Models\ProjectJob;
use Illuminate\Database\Eloquent\Collection;

class FetchSubmissions
{
    /**
     * @param \App\Models\ProjectJob $job
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function execute(ProjectJob $job): Collection
    {
        $submissions = $job->submissions()
            ->with(['crew' => function ($q) {
                $q->with('user');
            }])
            ->orderByDesc('approved_at')
            ->orderBy('rejected_at')
            ->get();
        return $submissions;
    }
}
