<?php

namespace Tests\Feature\Producer;

use App\Models\Project;
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
                    'pay_rate'             => '16',
                    'pay_rate_type_id'     => PayTypeID::PER_HOUR,
                    'dates_needed'         => '6/15/2018 - 6/25/2018',
                    'notes'                => 'Some Note',
                    'travel_expenses_paid' => 1,
                    'rush_call'            => 1,
                    'position_id'          => PositionID::CAMERA_OPERATOR,
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('producer/projects', $data);

        $response->assertSuccessful();

        $project = Project::whereTitle('Some Title')->whereUserId($user->id)->first();

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

        // assert jobs
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
    public function create_non_pay_rate()
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
                    'travel_expenses_paid' => 1,
                    'rush_call'            => 1,
                    'position_id'          => PositionID::CAMERA_OPERATOR,
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('producer/projects', $data);

        $response->assertSuccessful();

        $project = Project::whereTitle('Some Title')->whereUserId($user->id)->first();

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

        // assert jobs
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

        $project = Project::whereTitle('Some Title')->whereUserId($user->id)->first();

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
        ];

        $response = $this->actingAs($user)->post('producer/projects', $data);

        $response->assertSessionHasErrors([
            'title', // min 3 chars
            'production_name', // min 3 chars
            'production_name_public', // must be a boolean
            'project_type_id', // must exist on the project_types table
            'description', // min 3 chars
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
    public function create_unauthorized()
    {
        $user = $this->createCrewUser();

        $response = $this->actingAs($user)->post('producer/projects');

        $response->assertRedirect('/');
    }
}
