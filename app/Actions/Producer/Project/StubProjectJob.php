<?php

namespace App\Actions\Producer\Project;

use App\Models\ProjectJob;

class StubProjectJob
{
    public function create($request): ProjectJob
    {
        $data = $this->adjustPayType($request);
        $data = $this->filter($data);

        return ProjectJob::create($data);
    }

    public function update(ProjectJob $projectJob, array $request): ProjectJob
    {
        $data = $this->adjustPayType($request);
        $data = $this->filter($data);
        
        $projectJob->update($data);
        return $projectJob;
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

    private function adjustPayType($data)
    {
        if($data['pay_rate_type_id']){
            $data['pay_type_id'] = $data['pay_rate_type_id'];
        }

        return $data;
    }
}