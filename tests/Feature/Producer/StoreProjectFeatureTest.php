<?php

namespace Tests\Feature\Producer;

use App\Models\Project;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\Data\PayTypeID;
use Tests\Support\Data\PositionID;
use Tests\Support\Data\ProjectTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StoreProjectFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectsController::store
     */
    public function store()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'type_id'                => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'jobs'                   => [
                PositionID::CAMERA_OPERATOR => [
                    'persons_needed'        => '2',
                    'gear_provided'         => 'Some Gear Provided',
                    'gear_needed'           => 'Some Gear Needed',
                    'pay_rate'              => '16',
                    'pay_type_id'           => PayTypeID::PER_HOUR,
                    'dates_needed'          => '6/15/2018 - 6/25/2018',
                    'notes'                 => 'Some Note',
                    'rush_call'             => '1',
                    'position_id'           => PositionID::CAMERA_OPERATOR,
                    'travel_expenses_paid'  => '1',
                    'sites'                 => [1, 2,],
                ]
            ],
        ];

        $this->actingAs($user, 'api')
             ->get(route('producer.projects.index'));

        $response = $this->actingAs($user, 'api')
             ->post(route('producer.project.store'), $data);

        $response->assertJson([
            'message' => 'Project successfully added'
        ]);

        $project = Project::whereTitle('Some Title')
                          ->first();

        $this->assertArrayHas(
            [
                ['site_id' => $data['jobs'][PositionID::CAMERA_OPERATOR]['sites'][0]],
                ['site_id' => $data['jobs'][PositionID::CAMERA_OPERATOR]['sites'][1]],
            ],
            $project->remotes->toArray()
        );

        $this->assertCount(2, $project->remotes);
        $this->assertCount(1, $project->jobs);

        $this->assertArrayHas(
            [
                'title'                  => 'Some Title',
                'production_name'        => 'Some Production Name',
                'production_name_public' => true,
                'project_type_id'        => ProjectTypeID::TV,
                'description'            => 'Some Description',
                'location'               => 'Some Location',
                'status'                 => 0,
                'user_id'                => $user->id
            ],
            $project->toArray()
        );

        $this->assertArrayHas(
            [
                [
                    'persons_needed'       => 2,
                    'pay_rate'             => 16.00,
                    'pay_type_id'          => PayTypeID::PER_HOUR,
                    'dates_needed'         => '6/15/2018 - 6/25/2018',
                    'notes'                => 'Some Note',
                    'travel_expenses_paid' => true,
                    'rush_call'            => true,
                    'position_id'          => PositionID::CAMERA_OPERATOR,
                    'status'               => 0,
                ]
            ],
            $project->jobs->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectsController::store
     */
    public function store_with_job_non_pay_rate()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'type_id'                => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'jobs'                   => [
                PositionID::CAMERA_OPERATOR => [
                    'persons_needed'        => '2',
                    'gear_provided'         => 'Some Gear Provided',
                    'gear_needed'           => 'Some Gear Needed',
                    'pay_rate'              => '0',
                    'pay_type_id'           => PayTypeID::PER_HOUR,
                    'pay_type_id'           => PayTypeID::DOE,
                    'dates_needed'          => '6/15/2018 - 6/25/2018',
                    'notes'                 => 'Some Note',
                    'travel_expenses_paid'  => '1',
                    'rush_call'             => '1',
                    'position_id'           => PositionID::CAMERA_OPERATOR,
                    'sites'                 => [1,2]
                ],
            ],
        ];

        $this->actingAs($user, 'api')
             ->get(route('producer.projects.index'));

        $this->actingAs($user, 'api')
             ->post(route('producer.project.store'), $data);

        $project = Project::whereTitle('Some Title')
                          ->first();

        $this->assertArrayHas(
            [
                'title'                  => 'Some Title',
                'production_name'        => 'Some Production Name',
                'production_name_public' => true,
                'project_type_id'        => ProjectTypeID::TV,
                'description'            => 'Some Description',
                'location'               => 'Some Location',
                'status'                 => 0,
                'user_id'                => $user->id,
            ],
            $project->toArray()
        );

        $this->assertCount(2, $project->remotes);
        $this->assertCount(1, $project->jobs);

        $this->assertArrayHas(
            [
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
            ],
            $project->jobs->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectsController::store
     */
    public function store_with_job_has_no_gear_and_no_persons_needed()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'type_id'                => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'jobs'                   => [
                PositionID::FIRST_ASSISTANT_DIRECTOR => [
                    'pay_rate'             => '20',
                    'pay_type_id'          => PayTypeID::PER_HOUR,
                    'dates_needed'         => '6/15/2018 - 6/25/2018',
                    'notes'                => 'Some Note',
                    'travel_expenses_paid' => '1',
                    'rush_call'            => '1',
                    'position_id'          => PositionID::FIRST_ASSISTANT_DIRECTOR,
                    'sites'                => [1,2]
                ],
            ],
        ];

        $this->actingAs($user, 'api')
             ->get(route('producer.projects.index'));

        $this->actingAs($user, 'api')
             ->post(route('producer.project.store'), $data);

        $project = Project::whereTitle('Some Title')
            ->first();

        $this->assertArrayHas(
            [
                'title'                  => 'Some Title',
                'production_name'        => 'Some Production Name',
                'production_name_public' => true,
                'project_type_id'        => ProjectTypeID::TV,
                'description'            => 'Some Description',
                'location'               => 'Some Location',
                'status'                 => 0,
                'user_id'                => $user->id,
            ],
            $project->toArray()
        );

        $this->assertCount(1, $project->jobs);
        $this->assertArrayHas(
            [
                [
                    'gear_provided'        => null,
                    'gear_needed'          => null,
                    'pay_rate'             => 20.00,
                    'pay_type_id'          => PayTypeID::PER_HOUR,
                    'dates_needed'         => '6/15/2018 - 6/25/2018',
                    'notes'                => 'Some Note',
                    'travel_expenses_paid' => true,
                    'rush_call'            => true,
                    'position_id'          => PositionID::FIRST_ASSISTANT_DIRECTOR,
                    'status'               => 0
                ]
            ],
            $project->jobs->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectsController::store
     */
    public function store_with_many_jobs()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'jobs'                   => [
                PositionID::CAMERA_OPERATOR          => [
                    'persons_needed'       => '2',
                    'gear_provided'        => 'Some Gear Provided',
                    'gear_needed'          => 'Some Gear Needed',
                    'pay_rate'             => '16',
                    'pay_type_id'     => PayTypeID::PER_HOUR,
                    'dates_needed'         => '6/15/2018 - 6/25/2018',
                    'notes'                => 'Some Note',
                    'travel_expenses_paid' => '1',
                    'rush_call'            => '1',
                    'position_id'          => PositionID::CAMERA_OPERATOR,
                    'sites'                => [1,2]
                ],
                PositionID::FIRST_ASSISTANT_DIRECTOR => [
                    'pay_rate'             => '20',
                    'pay_type_id'     => PayTypeID::PER_HOUR,
                    'dates_needed'         => '6/15/2018 - 6/25/2018',
                    'notes'                => 'Some Note',
                    'travel_expenses_paid' => '1',
                    'rush_call'            => '1',
                    'position_id'          => PositionID::FIRST_ASSISTANT_DIRECTOR,
                    'sites'                => [1,2,3,4,5]
                ],
            ],
        ];

        $this->actingAs($user, 'api')
             ->get(route('producer.projects.index'));

        $this->actingAs($user, 'api')
             ->post(route('producer.project.store'), $data);

        $project = Project::whereTitle('Some Title')
            ->first();

        $this->assertArrayHas(
            [
                'title'                  => 'Some Title',
                'production_name'        => 'Some Production Name',
                'production_name_public' => true,
                'project_type_id'        => ProjectTypeID::TV,
                'description'            => 'Some Description',
                'location'               => 'Some Location',
                'status'                 => 0,
                'user_id'                => $user->id,
            ],
            $project->toArray()
        );

        $this->assertCount(2, $project->jobs);
        $this->assertArrayHas(
            [
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
                [
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
            ],
            $project->jobs->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectsController::store
     */
    public function store_unauthorized()
    {
        $user = $this->createCrew();

        $response = $this->actingAs($user)
            ->post(route('producer.projects'));

        $response->assertForbidden();
    }
}
