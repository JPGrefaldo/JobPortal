<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\ProjectJob;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FetchJobByPosition
{
    /**
     * Query jobs that are suitable for the crew based on its positions
     *
     * @param Crew $crew
     * @return Collection
     */
    public function execute(Crew $crew, $jobType)
    {
        if ($jobType === 'open') {
            return $this->fetchOpenJobs($crew);
        }
        if ($jobType === 'ignored') {
            return $this->fetchIgnoredJobs($crew);
        }
        if ($jobType === 'submission') {
            return $this->fetchSubmissions($crew);
        }
    }

    public function fetchIgnoredJobs($crew)
    {
        return ProjectJob::whereIn('position_id', $this->getPositionIds($crew))
            ->whereHas('crew_ignored_jobs')
            ->with('pay_type', 'position', 'project')
            ->withCount('submissions')
            ->get();
    }


    public function fetchOpenJobs($crew)
    {
        return ProjectJob::whereIn('position_id', $this->getPositionIds($crew))
            ->whereDoesntHave('crew_ignored_jobs')
            ->whereDoesntHave('submissions')
            ->with('pay_type', 'position', 'project')
            ->withCount('submissions')
            ->get();
    }

    public function fetchSubmissions($crew)
    {
        $date = Carbon::now()->subDays(90)->toDateTimeString();

        return ProjectJob::whereIn('position_id', $this->getPositionIds($crew))
            ->whereHas('submissions', function ($q) use ($date) {
                $q->where('created_at', '>=', $date);
            })
            ->with('pay_type', 'position', 'project')
            ->withCount('submissions')
            ->get();
    }
    

    /**
     * Get crew's position IDs
     *
     * @param Crew $crew
     * @return Array
     */
    private function getPositionIds(Crew $crew): array
    {
        $posIds = [];
        foreach ($crew->positions as $position) {
            array_push($posIds, $position->id);
        }

        return $posIds;
    }
}
