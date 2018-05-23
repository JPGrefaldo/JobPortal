<?php

namespace Tests\Unit\Services\Producer;

use App\Models\Project;
use App\Models\RemoteProject;
use App\Models\Site;
use App\Services\Producer\ProjectsServices;
use Tests\Support\Data\PayTypeID;
use Tests\Support\Data\PositionID;
use Tests\Support\Data\ProjectTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsServicesTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var \App\Services\Producer\ProjectsServices
     */
    private $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(ProjectsServices::class);
    }

    /** @test */
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

        $this->assertArraySubset([
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

    /** @test */
    public function create_project_invalid_input()
    {
        $input = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'status'                 => 1 // status will not be updated
        ];
        $user  = $this->createUser();
        $site  = $this->getCurrentSite();

        $project = $this->service->createProject($input, $user, $site);

        $this->assertArraySubset([
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

    /** @test */
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

        $this->assertArraySubset([
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

    /** @test */
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

        $this->assertArraySubset([
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

    /** @test */
    public function create_job()
    {
        $input   = [
            'persons_needed'       => '2',
            'gear_provided'        => 'Some Gear Provided',
            'gear_needed'          => 'Some Gear Needed',
            'pay_rate'             => '16',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => '1',
            'rush_call'            => '1',
            'position_id'          => PositionID::CAMERA_OPERATOR,
        ];
        $project = factory(Project::class)->create();

        $job = $this->service->createJob($input, $project);

        $this->assertArraySubset([
            'persons_needed'       => 2,
            'gear_provided'        => 'Some Gear Provided',
            'gear_needed'          => 'Some Gear Needed',
            'pay_rate'             => 16.00,
            'pay_type_id'          => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => true,
            'rush_call'            => true,
            'position_id'          => PositionID::CAMERA_OPERATOR,
            'status'               => 0,
        ], $job->refresh()->toArray());
    }

    /** @test */
    public function create_job_non_pay_rate()
    {
        $input   = [
            'persons_needed'       => '2',
            'gear_provided'        => 'Some Gear Provided',
            'gear_needed'          => 'Some Gear Needed',
            'pay_rate'             => '0',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'pay_type_id'          => PayTypeID::DOE,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => '1',
            'rush_call'            => '1',
            'position_id'          => PositionID::CAMERA_OPERATOR,
            'status'               => 1,
        ];
        $project = factory(Project::class)->create();

        $job = $this->service->createJob($input, $project);

        $this->assertArraySubset([
            'persons_needed'       => 2,
            'gear_provided'        => 'Some Gear Provided',
            'gear_needed'          => 'Some Gear Needed',
            'pay_rate'             => 0.00,
            'pay_type_id'          => PayTypeID::DOE,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => true,
            'rush_call'            => true,
            'position_id'          => PositionID::CAMERA_OPERATOR,
            'status'               => 0,
        ], $job->refresh()->toArray());
    }

    /** @test */
    public function create_job_has_no_gear_and_no_persons_needed()
    {
        $input   = [
            'pay_rate'             => '20',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => '1',
            'rush_call'            => '1',
            'position_id'          => PositionID::FIRST_ASSISTANT_DIRECTOR,
        ];
        $project = factory(Project::class)->create();

        $job = $this->service->createJob($input, $project);

        $this->assertArraySubset([
            'persons_needed'       => 1,
            'gear_provided'        => null,
            'gear_needed'          => null,
            'pay_rate'             => 20.00,
            'pay_type_id'          => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => true,
            'rush_call'            => true,
            'position_id'          => PositionID::FIRST_ASSISTANT_DIRECTOR,
            'status'               => 0,
        ], $job->refresh()->toArray());
    }

    /** @test */
    public function create_job_invalid_input()
    {
        $input   = [
            'persons_needed'       => '2',
            'gear_provided'        => 'Some Gear Provided',
            'gear_needed'          => 'Some Gear Needed',
            'pay_rate'             => '16',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => '1',
            'rush_call'            => '1',
            'position_id'          => PositionID::CAMERA_OPERATOR,
            'status'               => 1,
        ];
        $project = factory(Project::class)->create();

        $job = $this->service->createJob($input, $project);

        $this->assertArraySubset([
            'persons_needed'       => 2,
            'gear_provided'        => 'Some Gear Provided',
            'gear_needed'          => 'Some Gear Needed',
            'pay_rate'             => 16.00,
            'pay_type_id'          => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => true,
            'rush_call'            => true,
            'position_id'          => PositionID::CAMERA_OPERATOR,
            'status'               => 0,
        ], $job->refresh()->toArray());
    }

    /** @test */
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

        $this->assertArraySubset([
            'title'                  => 'Updated Title',
            'production_name'        => 'Updated Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Updated Description',
            'location'               => 'Updated Location',
        ], $project->refresh()->toArray());
    }

    /** @test */
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
        $this->assertArraySubset([
            ['site_id' => $remoteSites[0]],
            ['site_id' => $remoteSites[1]],
        ], $project->remotes->toArray());
    }

    /** @test */
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
        $this->assertArraySubset([
            ['site_id' => $remoteSites[1]],
            ['site_id' => $remoteSites[2]],
        ], $project->remotes->toArray());
    }

    /** @test */
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
        $this->assertArraySubset([
            ['site_id' => $remoteSites[0]],
            ['site_id' => $remoteSites[1]],
            ['site_id' => $remoteSites[2]],
        ], $project->remotes->toArray());
    }

    /** @test */
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
