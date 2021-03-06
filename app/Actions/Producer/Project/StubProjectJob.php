<?php

namespace App\Actions\Producer\Project;

use App\Http\Requests\Producer\CreateProjectJobRequest;
use App\Models\ProjectJob;
use Illuminate\Support\Arr;

class StubProjectJob
{
    /**
     * @param CreateProjectJobRequest $request
     * @return ProjectJob
     */
    public function create(CreateProjectJobRequest $request): ProjectJob
    {
        $data = $this->adjustPayType($request->all());
        $data = $this->filter($data);

        return ProjectJob::create($data);
    }

    /**
     * @param array $data
     * @return array
     */
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

    /**
     * @param array $data
     * @return array
     */
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

    /**
     * @param ProjectJob $projectJob
     * @param CreateProjectJobRequest $request
     * @return ProjectJob
     */
    public function update(ProjectJob $projectJob, CreateProjectJobRequest $request): ProjectJob
    {
        $data = $this->adjustPayType($request->all());
        $data = $this->filter($data);

        $projectJob->update($data);

        return $projectJob;
    }
}
