<?php

namespace App\Actions\Producer\Project;

use App\Models\ProjectJob;
use App\Models\Project;

class CreateProjectJob
{
    public function execute($request): ProjectJob
    {
        $data = $this->filter($request);

        return ProjectJob::create($data);
    }

    private function filter(array $data): array
    {
        return array_only($data, 
            [
                'project_id',
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
