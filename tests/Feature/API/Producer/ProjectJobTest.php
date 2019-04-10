<?php

namespace Tests\Feature\API\Producer;

use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\Support\Data\PayTypeID;
use Tests\Support\Data\PositionID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use function GuzzleHttp\json_encode;

class ProjectJobTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\ProjectJobsController::index
     */
    public function can_fetch_all_jobs()
    {
        $user = $this->createProducer();

        factory(ProjectJob::class)->create([
            'pay_rate'        => '100',
            'pay_type_id'     => PayTypeID::PER_HOUR,
            'position_id'     => PositionID::CAMERA_OPERATOR,
        ]);

        factory(ProjectJob::class)->create([
            'pay_type_id'     => PayTypeID::DOE,
            'position_id'     => PositionID::FIRST_ASSISTANT_DIRECTOR,
        ]);

        $response = $this->actingAs($user, 'api')
            ->get(route('producer.project.jobs'))
            ->assertSee('Sucessfully fetch the project\'s jobs.')
            ->assertStatus(Response::HTTP_OK);

        $response->assertJsonCount(2);

        $response->assertJsonFragment([
            'pay_rate'        => 100,
            'pay_type_id'     => PayTypeID::PER_HOUR,
            'position_id'     => PositionID::CAMERA_OPERATOR,
        ]);

        $response->assertJsonFragment([
            'pay_type_id'     => PayTypeID::DOE,
            'position_id'     => PositionID::FIRST_ASSISTANT_DIRECTOR,
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\ProjectJobsController::store
     */
    public function can_create_a_job()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);
        $data    = [
            'persons_needed'       => '2',
            'gear_provided'        => 'Some Gear Provided',
            'gear_needed'          => 'Some Gear Needed',
            'pay_rate'             => '16',
            'pay_type_id'          => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => '1',
            'rush_call'            => '1',
            'position_id'          => PositionID::CAMERA_OPERATOR,
            'project_id'           => $project->id,
        ];

        $response = $this->actingAs($user, 'api')
            ->post(
                             route('producer.project.jobs.store'),
                             $data,
                             [
                                 'Accept' => 'application/json',
                             ]
                         )
            ->assertSee('Sucessfully added the project\'s job.')
            ->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonFragment([
            'persons_needed'       => 2,
            'gear_provided'        => 'Some Gear Provided',
            'gear_needed'          => 'Some Gear Needed',
            'pay_rate'             => 16,
            'pay_type_id'          => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => true,
            'rush_call'            => true,
            'position_id'          => PositionID::CAMERA_OPERATOR,
            'project_id'           => $project->id,
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\ProjectJobsController::store
     */
    public function can_create_a_job_with_non_pay_rate()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);
        $data    = [
            'persons_needed'       => 2,
            'gear_provided'        => 'Some Gear Provided',
            'gear_needed'          => 'Some Gear Needed',
            'pay_rate'             => '',
            'pay_type_id'          => PayTypeID::DOE,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'position_id'          => PositionID::CAMERA_OPERATOR,
            'project_id'           => $project->id,
        ];

        $response = $this->actingAs($user, 'api')
            ->post(
                             route('producer.project.jobs.store'),
                             $data,
                             [
                                 'Accept' => 'application/json',
                             ]
                         )
            ->assertSee('Sucessfully added the project\'s job.')
            ->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonFragment([
            'persons_needed'       => 2,
            'gear_provided'        => 'Some Gear Provided',
            'gear_needed'          => 'Some Gear Needed',
            'pay_rate'             => 0,
            'pay_type_id'          => PayTypeID::DOE,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'position_id'          => PositionID::CAMERA_OPERATOR,
            'project_id'           => $project->id,
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\ProjectJobsController::store
     */
    public function can_create_a_job_with_no_gear_and_no_persons_needed()
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

        $this->actingAs($user, 'api')
            ->post(
                 route('producer.project.jobs.store'),
                 $data,
                 [
                     'Accept' => 'application/json',
                 ]
             )
            ->assertSee('Sucessfully added the project\'s job')
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\ProjectJobsController::store
     */
    public function can_create_a_job_with_multiple_dates()
    {
        $this->withExceptionHandling();

        $user    = $this->createProducer();
        $project = $this->createProject($user);

        $dates = [
            '2019-01-01',
            '2019-01-02',
            '2019-01-03',
            '2019-01-04',
            '2019-01-05'
        ];
        
        $data    = [
            'persons_needed'       => '2',
            'gear_provided'        => 'Some Gear Provided',
            'gear_needed'          => 'Some Gear Needed',
            'pay_rate'             => '16',
            'pay_type_id'          => PayTypeID::PER_HOUR,
            'dates_needed'         => $this->frontendJSONString($dates),
            'notes'                => 'Some Note',
            'travel_expenses_paid' => '1',
            'rush_call'            => '1',
            'position_id'          => PositionID::CAMERA_OPERATOR,
            'project_id'           => $project->id,
        ];

        $response = $this->actingAs($user, 'api')
            ->post(
                             route('producer.project.jobs.store'),
                             $data,
                             [
                                 'Accept' => 'application/json',
                             ]
                         )
            ->assertSee('Sucessfully added the project\'s job.')
            ->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonFragment([
            'dates_needed' => $this->frontendJSONString($dates)
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\ProjectJobsController::update
     */
    public function can_edit_a_job()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);

        $projectJob = factory(ProjectJob::class)->create(['project_id' => $project->id]);

        $data = [
            'persons_needed'       => '2',
            'gear_provided'        => 'Some Gear Provided',
            'gear_needed'          => 'Some Gear Needed',
            'pay_rate'             => '16',
            'pay_type_id'          => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => '1',
            'rush_call'            => '0',
            'position_id'          => PositionID::CAMERA_OPERATOR,
            'project_id'           => $project->id,
        ];

        $response = $this->actingAs($user, 'api')
            ->put(
                            route('producer.project.jobs.update', $projectJob),
                            $data,
                            [
                                'Accept' => 'application/json',
                            ]
                        )
            ->assertSee('Sucessfully updated the project\'s job.')
            ->assertStatus(Response::HTTP_OK);

        $response->assertJsonFragment(
            [
                'persons_needed'       => 2,
                'gear_provided'        => 'Some Gear Provided',
                'gear_needed'          => 'Some Gear Needed',
                'pay_rate'             => 16,
                'pay_type_id'          => PayTypeID::PER_HOUR,
                'dates_needed'         => '6/15/2018 - 6/25/2018',
                'notes'                => 'Some Note',
                'travel_expenses_paid' => true,
                'rush_call'            => false,
                'position_id'          => PositionID::CAMERA_OPERATOR,
                'project_id'           => $project->id,
            ]
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\ProjectJobsController::destroy
     */
    public function can_delete_a_job()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);

        $projectJob = factory(ProjectJob::class)->create(['project_id' => $project->id]);

        $response = $this->actingAs($user, 'api')
            ->delete(route('producer.project.jobs.destroy', $projectJob));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\ProjectJobsController::store
     */
    public function cannot_create_a_job_when_required_fields_are_empty()
    {
        $user = $this->createProducer();
        $data = [
            'persons_needed'       => '',
            'dates_needed'         => '',
            'notes'                => '',
            'position_id'          => '',
            'project_id'           => $this->createProject($user)->id,
        ];

        $this->actingAs($user)
            ->get(route('producer.projects.create'));

        $this->actingAs($user, 'api')
            ->post(
                route('producer.project.jobs.store'),
                $data,
                [
                    'Accept' => 'application/json',
                ]
            )
            ->assertSee('The given data was invalid.')
            ->assertSee('The persons needed field is required.')
            ->assertSee('The dates needed field is required.')
            ->assertSee('The notes field is required.')
            ->assertSee('The notes field is required.')
            ->assertSee('The position id field is required.')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\ProjectJobsController::store
     */
    public function cannot_create_a_job_when_data_is_invalid()
    {
        $user = $this->createProducer();
        $data = [
            'persons_needed'       => 'asdasd',
            'gear_provided'        => false,
            'gear_needed'          => false,
            'dates_needed'         => false,
            'notes'                => false,
            'position_id'          => 999,
            'project_id'           => $this->createProject($user)->id,
        ];

        $this->actingAs($user)
            ->post(route('producer.projects.create'));

        $this->actingAs($user, 'api')
            ->post(
                route('producer.project.jobs.store'),
                $data,
                [
                    'Accept' => 'application/json',
                ]
            )
            ->assertSee('The given data was invalid.')
            ->assertSee('The persons needed must be a number.')
            ->assertSee('The gear provided must be a string.')
            ->assertSee('The gear needed must be a string.')
            ->assertSee('The dates needed must be a string.')
            ->assertSee('The notes must be a string.')
            ->assertSee('The notes must be at least 3 characters.')
            ->assertSee('The selected position id is invalid.')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\ProjectJobsController::store
     */
    public function cannot_create_a_job_the_unauthorized_role()
    {
        $user = $this->createCrew();
        $data = [];

        $this->actingAs($user, 'api')
            ->post(
                 route('producer.project.jobs.store'),
                 $data,
                 [
                     'Accept' => 'application/json',
                 ]
             )
            ->assertSee('This action is unauthorized.')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\ProjectJobsController::update
     */
    public function cannot_edit_a_job_the_unauthorized_role()
    {
        $user = $this->createCrew();
        $data = [];

        $projectJob = factory(ProjectJob::class)->create(['project_id' => 1]);

        $this->actingAs($user, 'api')
            ->put(
                 route('producer.project.jobs.update', $projectJob),
                 $data,
                 [
                     'Accept' => 'application/json',
                 ]
             )
            ->assertSee('This action is unauthorized.')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\ProjectJobsController::destroy
     */
    public function cannot_delete_a_job_the_unauthorized_role()
    {
        $user = $this->createCrew();

        $projectJob = factory(ProjectJob::class)->create(['project_id' => 1]);

        $this->actingAs($user, 'api')
            ->delete(
                route('producer.project.jobs.destroy', $projectJob),
                [
                    'Accept' => 'application/json',
                ]
            )
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\ProjectJobsController::store
     */
    public function should_accept_pay_rate_type_id_when_no_pay_type_id()
    {
        $user = $this->createProducer();
        $project = $this->createProject($user);

        $data    = [
            'persons_needed'       => '2',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Some Note',
            'position_id'          => PositionID::CAMERA_OPERATOR,
            'project_id'           => $project->id,
        ];

        $this->actingAs($user)
            ->post(route('producer.projects.create'));

        $response = $this->actingAs($user, 'api')
            ->post(
                             route('producer.project.jobs.store'),
                             $data,
                             [
                                 'Accept' => 'application/json',
                             ]
                         )
            ->assertSee('Sucessfully added the project\'s job')
            ->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonFragment([
            'pay_type_id' => PayTypeID::PER_HOUR,
        ]);
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

    private function frontendJSONString($data){
        return json_encode($data);
    }
}
