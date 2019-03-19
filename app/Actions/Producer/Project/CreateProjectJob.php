<?php

namespace App\Actions\Producer\Project;

use App\Models\ProjectJob;
use App\Models\Project;

class CreateProjectJob
{
    public function execute(Project $project, array $jobs): void
    {
        foreach ($jobs as $job){
            $data = $this->filter($job);
            $data['project_id'] = $project->id;

            ProjectJob::create($data);
        }
    }

    private function filter(array $data): array
    {
        return array_only($data, 
            [
                'position_id',
                'pay_type_id',
                'notes',   
                'persons_needed',
                'dates_needed',
                'pay_rate',
                'rush_call',
                'travel_expenses_paid',
                'gear_provided',
                'gear_needed'
            ]
        );
    }
}
