<?php

namespace App\Actions\Producer\Project;

use App\Models\ProjectJob;

class CreateProjectJob
{
    //TODO: Refactor this
    public function execute($job, $project)
    {
        return ProjectJob::create([
            'project_id'           => $project->id,
            'position_id'          => $job['position_id'],
            'pay_type_id'          => $job['pay_type_id'],
            'notes'                => $job['notes'],
            'persons_needed'       => $job['persons_needed'],
            'dates_needed'         => $job['dates_needed'],
            'pay_rate'             => $job['pay_rate'],
            'rush_call'            => ($job['rush_call']) ? 1:0,
            'travel_expenses_paid' => isset($job['travel_expenses_paid']) ? true : false,
            'gear_provided'        => isset($job['gear_provided']) ? $job['gear_provided'] : null,
            'gear_needed'          => isset($job['gear_needed']) ? $job['gear_needed'] : null
        ]);
    }
}