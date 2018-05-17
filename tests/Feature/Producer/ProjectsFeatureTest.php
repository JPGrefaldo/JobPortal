<?php

namespace Tests\Feature\Producer;

use App\Models\Project;
use App\Models\Site;
use Tests\Support\Data\PayTypeID;
use Tests\Support\Data\PositionID;
use Tests\Support\Data\ProjectTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function create()
    {
        $user = $this->createProducer();
        $site = $this->getCurrentSite()->id;
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'sites'                  => [],
            'jobs'                   => [
                PositionID::CAMERA_OPERATOR => [
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
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('producer/projects', $data);

        $response->assertSuccessful();

        $project = Project::whereTitle('Some Title')->first();

        $this->assertArraySubset([
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => true,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'status'                 => 0,
            'user_id'                => $user->id,
            'site_id'                => $this->getCurrentSite()->id,
        ], $project->toArray());

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
        ], $project->jobs->first()->toArray());
    }

    /** @test */
    public function create_remote_sites()
    {
        $user = $this->createProducer();
        $site = $this->getCurrentSite()->id;
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'sites'                  => [
                factory(Site::class)->create()->id,
                factory(Site::class)->create()->id,
            ],
            'jobs'                   => [
                PositionID::CAMERA_OPERATOR => [
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
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('producer/projects', $data);

        $response->assertSuccessful();

        $project = Project::whereTitle('Some Title')->first();

        $this->assertArraySubset([
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => true,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'status'                 => 0,
            'user_id'                => $user->id,
            'site_id'                => $this->getCurrentSite()->id,
        ], $project->toArray());

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
        ], $project->jobs->first()->toArray());

        $this->assertArraySubset([
            ['site_id' => $data['sites'][0]],
            ['site_id' => $data['sites'][1]]
        ], $project->remotes->toArray());
    }

    /** @test */
    public function create_with_job_non_pay_rate()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'jobs'                   => [
                PositionID::CAMERA_OPERATOR => [
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
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('producer/projects', $data);

        $response->assertSuccessful();

        $project = Project::whereTitle('Some Title')->first();

        $this->assertArraySubset([
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => true,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'status'                 => 0,
            'user_id'                => $user->id,
        ], $project->toArray());

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
        ], $project->jobs->first()->toArray());
    }

    /** @test */
    public function create_with_job_has_no_gear_and_no_persons_needed()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'jobs'                   => [
                PositionID::FIRST_ASSISTANT_DIRECTOR => [
                    'pay_rate'             => '20',
                    'pay_rate_type_id'     => PayTypeID::PER_HOUR,
                    'dates_needed'         => '6/15/2018 - 6/25/2018',
                    'notes'                => 'Some Note',
                    'travel_expenses_paid' => '1',
                    'rush_call'            => '1',
                    'position_id'          => PositionID::FIRST_ASSISTANT_DIRECTOR,
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('producer/projects', $data);

        $response->assertSuccessful();

        $project = Project::whereTitle('Some Title')->first();

        $this->assertArraySubset([
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => true,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'status'                 => 0,
            'user_id'                => $user->id,
        ], $project->toArray());

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
        ], $project->jobs->first()->toArray());
    }

    /** @test */
    public function create_many_jobs()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'jobs'                   => [
                PositionID::CAMERA_OPERATOR          => [
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
                ],
                PositionID::FIRST_ASSISTANT_DIRECTOR => [
                    'pay_rate'             => '20',
                    'pay_rate_type_id'     => PayTypeID::PER_HOUR,
                    'dates_needed'         => '6/15/2018 - 6/25/2018',
                    'notes'                => 'Some Note',
                    'travel_expenses_paid' => '1',
                    'rush_call'            => '1',
                    'position_id'          => PositionID::FIRST_ASSISTANT_DIRECTOR,
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('producer/projects', $data);

        $response->assertSuccessful();

        $project = Project::whereTitle('Some Title')->first();

        $this->assertArraySubset([
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => true,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'status'                 => 0,
            'user_id'                => $user->id,
        ], $project->toArray());

        $this->assertCount(2, $project->jobs);

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
        ], $project->jobs->get(0)->toArray());

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
        ], $project->jobs->get(1)->toArray());
    }

    /** @test */
    public function create_not_required()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => '',
            'jobs'                   => [],
        ];

        $response = $this->actingAs($user)->post('producer/projects', $data);

        $response->assertSuccessful();

        $project = Project::whereTitle('Some Title')->first();

        $this->assertArraySubset([
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => true,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => null,
            'status'                 => 0,
            'user_id'                => $user->id,
        ], $project->toArray());

        $this->assertCount(0, $project->jobs);
    }

    /** @test */
    public function create_invalid()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => 'as',
            'production_name'        => 'as',
            'production_name_public' => 'asdasdas',
            'project_type_id'        => 999,
            'description'            => 'as',
            'location'               => '',
            'sites'                  => [998, 999],
            'jobs'                   => [
                999 => [
                    'persons_needed'       => 0,
                    'pay_rate'             => 'asdasd',
                    'pay_rate_type_id'     => 999,
                    'pay_type_id'          => 999,
                    'dates_needed'         => '',
                    'notes'                => 'ab',
                    'travel_expenses_paid' => 'y',
                    'rush_call'            => 'y',
                    'position_id'          => 999,
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('producer/projects', $data);

        $response->assertSessionHasErrors([
            'title', // min 3 chars
            'production_name', // min 3 chars
            'production_name_public', // must be a boolean
            'project_type_id', // must exist on the project_types table
            'description', // min 3 chars
            'sites.*', // must exist in the sites database
            'jobs.*.persons_needed', // must be greater than 0
            'jobs.*.pay_rate', // must be numeric
            'jobs.*.pay_rate_type_id', // must exist in the pay_rates table
            'jobs.*.pay_type_id', // must exist in the pay_rates table
            'jobs.*.dates_needed', // is required
            'jobs.*.notes', // min 3 chars
            'jobs.*.travel_expenses_paid', // must be boolean
            'jobs.*.rush_call', // must be boolean
            'jobs.*.position_id' // must exist in the positions table
        ]);
    }

    /** @test */
    public function create_invalid_basic()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => '',
            'production_name'        => '',
            'production_name_public' => '',
            'project_type_id'        => '',
            'description'            => '',
            'location'               => '',
        ];

        $response = $this->actingAs($user)->post('producer/projects', $data);

        $response->assertSessionHasErrors([
            'title', // required
            'production_name', // required
            'production_name_public', // required
            'project_type_id', // required
            'description', // required
        ]);
    }

    /** @test */
    public function create_job_requires_pay_type_id()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'jobs'                   => [
                PositionID::CAMERA_OPERATOR => [
                    'persons_needed'       => '2',
                    'gear_provided'        => 'Some Gear Provided',
                    'gear_needed'          => 'Some Gear Needed',
                    'pay_rate'             => '0',
                    'pay_rate_type_id'     => PayTypeID::PER_HOUR,
                    'dates_needed'         => '6/15/2018 - 6/25/2018',
                    'notes'                => 'Some Note',
                    'travel_expenses_paid' => '1',
                    'rush_call'            => '1',
                    'position_id'          => PositionID::CAMERA_OPERATOR,
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('producer/projects', $data);

        $response->assertSessionHasErrors([
            'jobs.*.pay_type_id', // is required if the rate is 0
        ]);
    }

    /** @test */
    public function create_unauthorized()
    {
        $user = $this->createCrewUser();

        $response = $this->actingAs($user)->post('producer/projects');

        $response->assertRedirect('/');
    }
}
