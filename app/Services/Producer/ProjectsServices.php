<?php


namespace App\Services\Producer;


use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\User;

class ProjectsServices
{
    /**
     * @param array            $input
     * @param \App\Models\User $user
     *
     * @return \App\Models\Project
     */
    public function create(array $input, User $user)
    {
        $data = array_only($input, [
            'title',
            'production_name',
            'production_name_public',
            'project_type_id',
            'description',
            'location',
        ]);

        $data['user_id'] = $user->id;

        return Project::create($data);
    }

    /**
     * @param array               $input
     * @param \App\Models\Project $project
     *
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function createJob(array $input, Project $project)
    {
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
        $data['pay_type_id'] = floatval($data['pay_rate']) > 0
            ? $input['pay_rate_type_id']
            : $input['pay_type_id'];

        return ProjectJob::create($data);
    }
}
