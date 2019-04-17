<?php

namespace App\Actions\Producer\Project;

use Illuminate\Support\Arr;
use App\Http\Requests\Producer\CreateProjectJobRequest;
use App\Models\ProjectJob;

class StubProjectJob
{
    public function create(CreateProjectJobRequest $request): ProjectJob
    {
        $data = $this->adjustPayType($request->all());
        $data = $this->filter($data);

        return ProjectJob::create($data);
    }

    public function update(ProjectJob $projectJob, CreateProjectJobRequest $request): ProjectJob
    {
        $data = $this->adjustPayType($request->all());
        $data = $this->filter($data);

        $projectJob->update($data);

        return $projectJob;
    }

    private function filter(array $data): array
    {
        return Arr::only(
            $data,
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
                'gear_needed',
            ]
        );
    }

    private function adjustPayType(array $data): array
    {
        if (! isset($data['pay_rate'])) {
            $data['pay_rate'] = 0;
        }

        if (isset($data['pay_rate_type_id'])) {
            $data['pay_type_id'] = $data['pay_rate_type_id'];
        }

        return $data;
    }
}
