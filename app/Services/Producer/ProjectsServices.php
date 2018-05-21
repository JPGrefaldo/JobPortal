<?php


namespace App\Services\Producer;


use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\RemoteProject;
use App\Models\Site;
use App\Models\User;

class ProjectsServices
{
    /**
     * @param array            $input
     * @param \App\Models\User $user
     * @param \App\Models\Site $site
     *
     * @return \App\Models\Project
     */
    public function create(array $input, User $user, Site $site)
    {
        $project = $this->createProject($input, $user, $site);

        $this->createRemoteProjects($input['sites'], $project, $site);
        $this->createJobs($input['jobs'], $project);

        return $project;
    }

    /**
     * @param array               $remoteSites
     * @param \App\Models\Project $project
     * @param \App\Models\Site    $site
     */
    public function createRemoteProjects(array $remoteSites, Project $project, Site $site)
    {
        if (empty($remoteSites)) {
            return;
        }

        $remoteSites = array_diff($remoteSites, [$site->id]);

        foreach ($remoteSites as $siteId) {
            RemoteProject::create([
                'project_id' => $project->id,
                'site_id'    => $siteId
            ]);
        }
    }

    /**
     * @param array            $input
     * @param \App\Models\User $user
     *
     * @return \App\Models\Project
     */
    public function createProject(array $input, User $user, Site $site)
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
        $data['site_id'] = $site->id;

        return Project::create($data);
    }

    /**
     * @param array               $jobInput
     * @param \App\Models\Project $project
     */
    public function createJobs(array $jobInput, Project $project)
    {
        foreach ($jobInput as $input) {
            $this->createJob($input, $project);
        }
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
        $data['pay_type_id'] = (floatval($data['pay_rate']) > 0)
            ? $input['pay_rate_type_id']
            : $input['pay_type_id'];

        return ProjectJob::create($data);
    }
}
