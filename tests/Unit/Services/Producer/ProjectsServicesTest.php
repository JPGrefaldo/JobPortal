<?php

namespace Tests\Unit\Services\Producer;

use App\Models\Project;
use App\Models\RemoteProject;
use App\Models\Site;
use App\Services\Producer\ProjectsServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\Data\ProjectTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ProjectsServicesTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var \App\Services\Producer\ProjectsServices
     */
    private $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(ProjectsServices::class);
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectsServices::createProject
     */
    public function create_project()
    {
        $input = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
        ];
        $user  = $this->createUser();
        $site  = $this->getCurrentSite();

        $project = $this->service->createProject($input, $user, $site);

        $this->assertArrayHas([
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => true,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'status'                 => 0,
            'user_id'                => $user->id,
            'site_id'                => $site->id,
        ], $project->refresh()->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectsServices::createProject
     */
    public function create_project_invalid_input()
    {
        $input = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'status'                 => 1, // status will not be updated
        ];
        $user  = $this->createUser();
        $site  = $this->getCurrentSite();

        $project = $this->service->createProject($input, $user, $site);

        $this->assertArrayHas([
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => true,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'status'                 => 0,
            'user_id'                => $user->id,
            'site_id'                => $site->id,
        ], $project->refresh()->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectsServices::createRemoteProjects
     */
    public function create_remote_projects()
    {
        $site        = $this->getCurrentSite();
        $project     = factory(Project::class)->create(['site_id' => $site->id]);
        $remoteSites = [
            factory(Site::class)->create()->id,
            factory(Site::class)->create()->id,
        ];

        $this->service->createRemoteProjects($remoteSites, $project, $site);

        $remoteProjects = RemoteProject::where('project_id', $project->id)->get();

        $this->assertCount(2, $remoteProjects);

        $this->assertArrayHas([
            [
                'project_id' => $project->id,
                'site_id'    => $remoteSites[0],
            ],
            [
                'project_id' => $project->id,
                'site_id'    => $remoteSites[1],
            ],
        ], $remoteProjects->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectsServices::createRemoteProjects
     */
    public function create_remote_projects_remove_current_site()
    {
        $site          = $this->getCurrentSite();
        $project       = factory(Project::class)->create(['site_id' => $site->id]);
        $remoteSites   = [$site->id];
        $remoteSites[] = factory(Site::class)->create()->id;
        $remoteSites[] = factory(Site::class)->create()->id;

        $this->service->createRemoteProjects($remoteSites, $project, $site);

        $remoteProjects = RemoteProject::where('project_id', $project->id)->get();

        $this->assertCount(2, $remoteProjects);

        $this->assertArrayHas([
            [
                'project_id' => $project->id,
                'site_id'    => $remoteSites[1],
            ],
            [
                'project_id' => $project->id,
                'site_id'    => $remoteSites[2],
            ],
        ], $remoteProjects->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectsServices::updateProject
     */
    public function update_project()
    {
        $project = factory(Project::class)->create();
        $input   = [
            'title'                  => 'Updated Title',
            'production_name'        => 'Updated Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Updated Description',
            'location'               => 'Updated Location',
        ];

        $this->service->updateProject($input, $project);

        $this->assertArrayHas([
            'title'                  => 'Updated Title',
            'production_name'        => 'Updated Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Updated Description',
            'location'               => 'Updated Location',
        ], $project->refresh()->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectsServices::updateRemoteProjects
     */
    public function update_remote_projects_no_existing_remotes()
    {
        $site        = $this->getCurrentSite();
        $project     = factory(Project::class)->create(['site_id' => $site->id]);
        $remoteSites = [
            factory(Site::class)->create()->id,
            factory(Site::class)->create()->id,
        ];

        $this->service->updateRemoteProjects($remoteSites, $project, $site);

        $this->assertCount(2, $project->remotes);
        $this->assertArrayHas([
            ['site_id' => $remoteSites[0]],
            ['site_id' => $remoteSites[1]],
        ], $project->remotes->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectsServices::updateRemoteProjects
     */
    public function update_remote_projects_does_not_include_current_site()
    {
        $site        = $this->getCurrentSite();
        $project     = factory(Project::class)->create(['site_id' => $site->id]);
        $remoteSites = [
            $site->id,
            factory(Site::class)->create()->id,
            factory(Site::class)->create()->id,
        ];

        $this->service->updateRemoteProjects($remoteSites, $project, $site);

        $this->assertCount(2, $project->remotes);
        $this->assertArrayHas([
            ['site_id' => $remoteSites[1]],
            ['site_id' => $remoteSites[2]],
        ], $project->remotes->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectsServices::updateRemoteProjects
     */
    public function update_remote_projects_with_existing_remotes()
    {
        $site          = $this->getCurrentSite();
        $project       = factory(Project::class)->create(['site_id' => $site->id]);
        $remoteProject = factory(RemoteProject::class)->create(['project_id' => $project->id]);
        $remoteSites   = [
            $remoteProject->site_id,
            factory(Site::class)->create()->id,
            factory(Site::class)->create()->id,
        ];

        $this->service->updateRemoteProjects($remoteSites, $project, $site);

        $this->assertCount(3, $project->remotes);
        $this->assertArrayHas([
            ['site_id' => $remoteSites[0]],
            ['site_id' => $remoteSites[1]],
            ['site_id' => $remoteSites[2]],
        ], $project->remotes->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectsServices::updateRemoteProjects
     */
    public function update_remote_projects_delete_all_existing_remotes()
    {
        $site          = $this->getCurrentSite();
        $project       = factory(Project::class)->create(['site_id' => $site->id]);
        $remoteProject = factory(RemoteProject::class)->create(['project_id' => $project->id]);
        $remoteSites   = [];

        $this->service->updateRemoteProjects($remoteSites, $project, $site);

        $this->assertCount(0, $project->remotes);
    }
}
