<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\ProjectJob;
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
        if ($jobType === 'open')    return $this->fetch_open_jobs($crew);
        if ($jobType === 'ignored') return $this->fetch_ignored_jobs($crew);
    }


    public function fetch_open_jobs($crew)
    {
        return ProjectJob::whereIn('position_id', $this->getPositionIds($crew))
                        ->whereDoesntHave('crew_ignored_jobs')
                        ->whereDoesntHave('submissions')
                        ->with('pay_type', 'position', 'project')
                        ->withCount('submissions')
                        ->get();
    }

    public function fetch_ignored_jobs($crew)
    {
        return ProjectJob::whereIn('position_id', $this->getPositionIds($crew))
                        ->whereHas('crew_ignored_jobs')
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
    private function getPositionIds(Crew $crew): Array
    {
        $posIds = [];
        foreach ($crew->positions as $position) {
            array_push($posIds, $position->id);
        }

        return $posIds;
    }
}