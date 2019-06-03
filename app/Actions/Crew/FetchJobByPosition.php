<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\ProjectJob;
use Illuminate\Database\Eloquent\Collection;

class FetchJobByPosition
{
    /**
     * Query jobs that are suitable for the crew based on its positions
     *
     * @param Crew $crew
     * @return Collection
     */
    public function execute(Crew $crew): Collection
    {
        return ProjectJob::whereIn('position_id', $this->getPositionIds($crew))
                        ->with('pay_type', 'position')
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