<?php

namespace Tests\Feature\Producer;

use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\Data\PayTypeID;
use Tests\Support\Data\PositionID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CreateProjectJobTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::store
     */
    public function create()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);
        $data    = [
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

        $response = $this->actingAs($user)
            ->post(route('producer.jobs'), $data);

        $response->assertSuccessful();

        $this->assertArrayHas(
            [
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
            ],
            $project->jobs()
                ->first()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::store
     */
    public function create_with_invalid_data()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);
        $data    = [
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

        $response = $this->actingAs($user)
            ->post(route('producer.jobs'), $data);

        $response->assertSuccessful();

        $this->assertArrayHas(
            [
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
            ],
            $project->jobs()
                ->first()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::store
     */
    public function create_with_non_pay_rate()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);
        $data    = [
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
        ];

        $response = $this->actingAs($user)
            ->post(route('producer.jobs'), $data);

        $response->assertSuccessful();

        $this->assertArrayHas(
            [
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
            ],
            $project->jobs()
                ->first()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::store
     */
    public function create_has_no_gear_and_no_persons_needed()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);
        $data    = [
            'pay_rate'             => '20',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => '1',
            'rush_call'            => '1',
            'position_id'          => PositionID::FIRST_ASSISTANT_DIRECTOR,
            'project_id'           => $project->id,
        ];

        $response = $this->actingAs($user)
            ->post(route('producer.jobs'), $data);

        $response->assertSuccessful();

        $this->assertArrayHas(
            [
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
            ],
            $project->jobs()
                ->first()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::store
     */
    public function create_with_existing_job()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);

        factory(ProjectJob::class)->create(['project_id' => $project->id]);

        $data = [
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

        $response = $this->actingAs($user)
            ->post(route('producer.jobs'), $data);

        $response->assertSuccessful();

        $this->assertCount(2, $project->jobs);
        $this->assertArrayHas(
            [
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
            ],
            $project->jobs->last()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::store
     */
    public function create_invalid_required()
    {
        $user = $this->createProducer();
        $data = [
            'dates_needed'         => '',
            'notes'                => '',
            'travel_expenses_paid' => '',
            'rush_call'            => '',
            'position_id'          => '',
            'project_id'           => $this->createProject($user)->id,
        ];

        $response = $this->actingAs($user)
            ->post(route('producer.jobs'), $data);

        $response->assertSessionHasErrors([
            'dates_needed',
            'notes',
            'travel_expenses_paid',
            'rush_call',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::store
     */
    public function create_invalid_required_sometimes()
    {
        $user = $this->createProducer();
        $data = [
            'persons_needed' => '',
            'project_id'     => $this->createProject($user)->id,
        ];

        $response = $this->actingAs($user)
            ->post(route('producer.jobs'), $data);

        $response->assertSessionHasErrors([
            'persons_needed',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::store
     */
    public function create_invalid_data()
    {
        $user = $this->createProducer();
        $data = [
            'persons_needed'       => 'asdasd',
            'gear_provided'        => false,
            'gear_needed'          => false,
            'pay_rate'             => 'asdasd',
            'pay_rate_type_id'     => 999,
            'pay_type_id'          => 999,
            'dates_needed'         => false,
            'notes'                => false,
            'travel_expenses_paid' => 'asdasd',
            'rush_call'            => 'asdasd',
            'position_id'          => 999,
            'project_id'           => $this->createProject($user)->id,
        ];

        $response = $this->actingAs($user)
            ->post(route('producer.jobs'), $data);

        $response->assertSessionHasErrors([
            'persons_needed', // must be numeric
            'gear_provided', // must be a string
            'gear_needed', // must be a string
            'pay_rate', // must be numeric
            'pay_rate_type_id', // must exist on the pay_rates table
            'pay_type_id', // must exist on the pay_rates table
            'dates_needed', // must be a string
            'notes', // must be a string
            'travel_expenses_paid', // must be a boolean
            'rush_call', // must be a boolean
            'position_id', // must exist on the positions table
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::store
     */
    public function create_invalid_requires_pay_type_id_when_zero_rate()
    {
        $user = $this->createProducer();
        $data = [
            'pay_rate'             => '0',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => '1',
            'rush_call'            => '0',
            'position_id'          => PositionID::FIRST_ASSISTANT_DIRECTOR,
            'project_id'           => $this->createProject($user)->id,
        ];

        $response = $this->actingAs($user)
            ->post(route('producer.jobs'), $data);

        $response->assertSessionHasErrors([
            'pay_type_id',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::store
     */
    public function create_unauthorized_role()
    {
        $user = $this->createCrew();
        $data = [];

        $response = $this->actingAs($user)
            ->post(route('producer.jobs'), $data);

        $response->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::store
     */
    public function create_unauthorized_no_project_id()
    {
        $user    = $this->createProducer();
        $project = factory(Project::class)->create();
        $data    = [];

        $response = $this->actingAs($user)
            ->post(route('producer.jobs'), $data);

        $response->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::store
     */
    public function create_unauthorized_project_does_not_exist()
    {
        $user    = $this->createProducer();
        $project = factory(Project::class)->create();
        $data    = [
            'project_id' => 999,
        ];

        $response = $this->actingAs($user)
            ->post(route('producer.jobs'), $data);

        $response->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::store
     */
    public function create_unauthorized_user_does_not_own_project()
    {
        $user    = $this->createProducer();
        $project = factory(Project::class)->create();
        $data    = [
            'project_id' => $project->id,
        ];

        $response = $this->actingAs($user)
            ->post(route('producer.jobs'), $data);

        $response->assertForbidden();
    }

    /**
     * @param \App\Models\User $user
     *
     * @return \App\Models\Project
     */
    private function createProject(User $user)
    {
        $attributes['user_id'] = $user->id;
        $attributes['site_id'] = $this->getCurrentSite()->id;

        return factory(Project::class)->create($attributes);
    }
}
