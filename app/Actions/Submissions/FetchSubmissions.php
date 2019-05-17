<?php

namespace App\Actions\Submissions;

use App\Models\ProjectJob;
use Illuminate\Database\Eloquent\Collection;

class FetchSubmissions
{
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
