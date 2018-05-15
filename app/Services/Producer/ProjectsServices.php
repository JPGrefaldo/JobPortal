<?php


namespace App\Services\Producer;


use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\User;

class ProjectsServices
{
    public function processCreate(array $input, User $user)
    {
        $project = $this->create(array_only($input, [
            'title',
            'production_name',
            'production_name_public',
            'project_type_id',
            'description',
            'location',
        ]), $user);

        foreach ($input['jobs'] as $data) {
            $this->createJob($data, $project);
        }
    }

    public function create(array $data, User $user)
    {
        $data['user_id'] = $user->id;

        return Project::create($data);
    }

    public function createJob($input, Project $project)
    {
        /** @temp */
        $data = array_only($input, [
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

        $data['project_id']  = $project->id;
        $data['pay_type_id'] = (float)$data['pay_rate'] > 0
            ? $input['pay_rate_type_id']
            : $input['pay_type_id'];

        ProjectJob::create($data);
    }
}
