<?php

namespace Tests\Unit\Services\Producer;

use App\Models\Project;
use App\Models\ProjectJob;
use App\Services\Producer\ProjectJobsService;
use Tests\Support\Data\PayTypeID;
use Tests\Support\Data\PositionID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectJobsServiceTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var \App\Services\Producer\ProjectJobsService
     */
    private $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(ProjectJobsService::class);
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectJobsService::create
     */
    public function create()
    {
        $project = factory(Project::class)->create();
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
            'project_id'           => $project->id,
        ];

        $job = $this->service->create($input);

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
            'project_id'           => $project->id,
            'status'               => 0,
        ], $job->refresh()->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectJobsService::create
     */
    public function create_with_invalid_input()
    {
        $project = factory(Project::class)->create();
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
            'project_id'           => $project->id,
            'status'               => '1',
        ];

        $job = $this->service->create($input);

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
            'project_id'           => $project->id,
            'status'               => 0,
        ], $job->refresh()->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectJobsService::create
     */
    public function create_non_pay_rate()
    {
        $project = factory(Project::class)->create();
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
            'project_id'           => $project->id,
            'status'               => '1',
        ];

        $job = $this->service->create($input);

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
            'project_id'           => $project->id,
            'status'               => 0,
        ], $job->refresh()->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectJobsService::create
     */
    public function create_has_no_gear_and_no_persons_needed()
    {
        $project = factory(Project::class)->create();
        $input   = [
            'pay_rate'             => '20',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => '1',
            'rush_call'            => '1',
            'position_id'          => PositionID::FIRST_ASSISTANT_DIRECTOR,
            'project_id'           => $project->id,
        ];

        $job = $this->service->create($input);

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

    /**
     * @test
     * @covers \App\Services\Producer\ProjectJobsService::update
     */
    public function update()
    {
        $input = [
            'persons_needed'       => '3',
            'gear_provided'        => 'Updated Gear Provided',
            'gear_needed'          => 'Updated Gear Needed',
            'pay_rate'             => '17',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => '1',
            'rush_call'            => '0',
        ];
        $job   = factory(ProjectJob::class)->create();

        $this->service->update($input, $job);

        $this->assertArraySubset([
            'persons_needed'       => 3,
            'gear_provided'        => 'Updated Gear Provided',
            'gear_needed'          => 'Updated Gear Needed',
            'pay_rate'             => '17',
            'pay_type_id'          => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => true,
            'rush_call'            => false,
        ], $job->refresh()->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectJobsService::update
     */
    public function update_with_invalid_params()
    {
        $input = [
            'persons_needed'       => '3',
            'gear_provided'        => 'Updated Gear Provided',
            'gear_needed'          => 'Updated Gear Needed',
            'pay_rate'             => '17',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => '1',
            'rush_call'            => '0',
            'status'               => '1',
            'position_id'          => PositionID::FIRST_ASSISTANT_DIRECTOR,
        ];
        $job   = factory(ProjectJob::class)->create([
            'position_id' => PositionID::CAMERA_OPERATOR,
        ]);

        $this->service->update($input, $job);

        $this->assertArraySubset([
            'persons_needed'       => 3,
            'gear_provided'        => 'Updated Gear Provided',
            'gear_needed'          => 'Updated Gear Needed',
            'pay_rate'             => 17.00,
            'pay_type_id'          => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => true,
            'rush_call'            => false,
            'position_id'          => PositionID::CAMERA_OPERATOR
        ], $job->refresh()->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectJobsService::update
     */
    public function update_non_pay_rate()
    {
        $input = [
            'persons_needed'       => '3',
            'gear_provided'        => 'Updated Gear Provided',
            'gear_needed'          => 'Updated Gear Needed',
            'pay_rate'             => '0',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'pay_type_id'          => PayTypeID::DOE,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => '1',
            'rush_call'            => '0',
        ];
        $job   = factory(ProjectJob::class)->create();

        $this->service->update($input, $job);

        $this->assertArraySubset([
            'persons_needed'       => 3,
            'gear_provided'        => 'Updated Gear Provided',
            'gear_needed'          => 'Updated Gear Needed',
            'pay_rate'             => 0.00,
            'pay_type_id'          => PayTypeID::DOE,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => true,
            'rush_call'            => false,
        ], $job->refresh()->toArray());
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectJobsService::filterCreateData
     */
    public function filter_create_data()
    {
        $this->assertSame(
            [
                'persons_needed'       => '2',
                'gear_provided'        => 'Some Gear Provided',
                'gear_needed'          => 'Some Gear Needed',
                'pay_rate'             => '16',
                'dates_needed'         => '6/15/2018 - 6/25/2018',
                'notes'                => 'Some Note',
                'travel_expenses_paid' => '1',
                'rush_call'            => '1',
                'position_id'          => PositionID::CAMERA_OPERATOR,
                'project_id'           => '2',
            ],
            $this->service->filterCreateData([
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
                'project_id'           => '2',
                'status'               => '1',
            ])
        );
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectJobsService::filterUpdateData
     */
    public function filter_update_data()
    {
        $this->assertSame(
            [
                'persons_needed'       => '3',
                'gear_provided'        => 'Updated Gear Provided',
                'gear_needed'          => 'Updated Gear Needed',
                'pay_rate'             => '17',
                'dates_needed'         => '6/15/2018 - 6/25/2018',
                'notes'                => 'Updated Notes',
                'travel_expenses_paid' => '1',
                'rush_call'            => '0',
            ],
            $this->service->filterUpdateData([
                'persons_needed'       => '3',
                'gear_provided'        => 'Updated Gear Provided',
                'gear_needed'          => 'Updated Gear Needed',
                'pay_rate'             => '17',
                'pay_rate_type_id'     => PayTypeID::PER_HOUR,
                'dates_needed'         => '6/15/2018 - 6/25/2018',
                'notes'                => 'Updated Notes',
                'travel_expenses_paid' => '1',
                'rush_call'            => '0',
                'position_id'          => '5',
                'status'               => '1',
                'project_id'           => '2',
            ])
        );
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectJobsService::getPayTypeId
     */
    public function get_pay_type_id_with_rate()
    {
        $this->assertEquals(
            PayTypeID::PER_HOUR,
            $this->service->getPayTypeId(16, [
                'pay_rate_type_id' => PayTypeID::PER_HOUR,
                'pay_type_id'      => PayTypeID::DOE,
            ])
        );
    }

    /**
     * @test
     * @covers \App\Services\Producer\ProjectJobsService::getPayTypeId
     */
    public function get_pay_type_id_without_rate()
    {
        $this->assertEquals(
            PayTypeID::DOE,
            $this->service->getPayTypeId(0, [
                'pay_rate_type_id' => PayTypeID::PER_HOUR,
                'pay_type_id'      => PayTypeID::DOE,
            ])
        );
    }
}
