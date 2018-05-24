<?php


namespace App\Services\Producer;


use App\Models\ProjectJob;

class ProjectJobsService
{
    /**
     * @param array                  $input
     * @param \App\Models\ProjectJob $job
     *
     * @return \App\Models\ProjectJob
     */
    public function update(array $input, ProjectJob $job)
    {
        $data = $this->filterUpdateData($input);

        $data['pay_type_id'] = $this->getPayTypeId($data['pay_rate'], $input);

        $job->update($data);

        return $job;
    }

    /**
     * @param $input
     *
     * @return array
     */
    public function filterUpdateData(array $input)
    {
        return array_only($input, [
            'persons_needed',
            'gear_provided',
            'gear_needed',
            'pay_rate',
            'dates_needed',
            'notes',
            'travel_expenses_paid',
            'rush_call',
            'position_id',
        ]);
    }

    /**
     * @param string|int $rate
     * @param array $input
     *
     * @return string|int
     */
    public function getPayTypeId($rate, array $input)
    {
        return (floatval($rate) > 0)
            ? $input['pay_rate_type_id']
            : $input['pay_type_id'];
    }
}
