<?php

namespace App\Actions\Producer\Project;

use App\Models\ProjectJob;

class CreateProjectJob
{
    public function execute($job, $project, $request)
    {
        return ProjectJob::create([
                              'project_id' => $project->id,
                              'position_id' => $job['position_id'],
                              'pay_type_id' => $job['pay_type_id'],
                              'persons_needed' => 0, //Not included in the frontend
                              'dates_needed' => $job['dates_needed'],
                              'pay_rate' => $job['pay_rate'],
                              'rush_call' => ($job['rush_call']) ? 1:0,
                              'travel_expenses_paid' => $request['paid_travel'],
                              'gear_provided' => null,
                              'gear_needed' => null
                          ]);
    }
}