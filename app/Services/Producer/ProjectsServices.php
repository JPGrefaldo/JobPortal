<?php

namespace App\Services\Producer;

use App\Models\Project;
use App\Models\RemoteProject;
use App\Models\Site;
use App\Models\User;
use Exception;
use Illuminate\Support\Arr;

class ProjectsServices
{
    /**
     * @param array $input
     * @param User $user
     * @param Site $site
     *
     * @return Project
     */
    public function create(array $input, User $user, Site $site)
    {
        $project = $this->createProject($input, $user, $site);

        $this->createRemoteProjects($input['sites'], $project, $site);
        $this->createJobs($input['jobs'], $project);

        return $project;
    }

    /**
     * @param array $input
     * @param User $user
     *
     * @return Project
     */
    public function createProject(array $input, User $user, Site $site)
    {
        $data = $this->prepareData($input);

        $data['user_id'] = $user->id;
        $data['site_id'] = $site->id;

        return Project::create($data);
    }

    /**
     * @param array $input
     *
     * @return array
     */
    public function prepareData(array $input)
    {
        return Arr::only($input, [
            'title',
            'production_name',
            'production_name_public',
            'project_type_id',
            'description',
            'location',
        ]);
    }

    /**
     * @param array $remoteSites
     * @param Project $project
     * @param Site $site
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
                'site_id'    => $siteId,
            ]);
        }
    }

    /**
     * @param array $jobInput
     * @param Project $project
     */
    public function createJobs(array $jobInput, Project $project)
    {
        $jobsService = app(ProjectJobsService::class);

        foreach ($jobInput as $input) {
            $input['project_id'] = $project->id;

            $jobsService->create($input);
        }
    }

    /**
     * @param array $input
     * @param Project $project
     * @param Site $site
     *
     * @return Project
     * @throws Exception
     */
    public function update(array $input, Project $project, Site $site)
    {
        $project = $this->updateProject($input, $project);

        $this->updateRemoteProjects($input['sites'], $project, $site);

        return $project;
    }

    /**
     * @param array $input
     * @param Project $project
     *
     * @return Project
     */
    public function updateProject(array $input, Project $project)
    {
        $project->update($this->prepareData($input));

        return $project;
    }

    /**
     * @param array $remoteSites
     * @param Project $project
     * @param Site $site
     *
     * @throws Exception
     */
    public function updateRemoteProjects(array $remoteSites, Project $project, Site $site)
    {
        RemoteProject::where('project_id', $project->id)->delete();

        $this->createRemoteProjects($remoteSites, $project, $site);
    }
}
