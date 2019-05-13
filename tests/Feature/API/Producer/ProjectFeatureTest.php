<?php

namespace Tests\Feature\Producer;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\Support\Data\PayTypeID;
use Tests\Support\Data\PositionID;
use Tests\Support\Data\ProjectTypeID;
use Tests\Support\Data\SiteID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ProjectFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectController::index
     */
    public function can_fetch_all_projects()
    {
        $user = $this->createProducer();

        factory(Project::class)->create([
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
        ]);

        factory(Project::class)->create([
            'production_name_public' => 0,
            'project_type_id'        => ProjectTypeID::MOVIE,
            'status'                 => 1,
        ]);

        $response = $this->actingAs($user, 'api')
            ->get(route('producer.projects.index'))
            ->assertSee('Succesfully fetched all projects.')
            ->assertSuccessful();

        $response->assertJsonCount(2);

        $response->assertJsonFragment([
            'production_name_public' => true,
            'project_type_id'        => ProjectTypeID::TV,
        ]);

        $response->assertJsonFragment([
            'production_name_public' => false,
            'project_type_id'        => ProjectTypeID::MOVIE,
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectController::pending
     */
    public function can_fetch_all_pending_projects()
    {
        $user = $this->createProducer();

        factory(Project::class)->create([
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
        ]);

        factory(Project::class)->create([
            'production_name_public' => 0,
            'project_type_id'        => ProjectTypeID::MOVIE,
            'status'                 => 1,
        ]);

        $response = $this->actingAs($user, 'api')
            ->get(route('producer.projects.pending'))
            ->assertSee('Succesfully fetched all pending projects.')
            ->assertSuccessful();

        $response->assertJsonCount(2);

        $response->assertJsonFragment([
            'status'                 => 0,
            'project_type_id'        => ProjectTypeID::TV,
        ]);

        $response->assertJsonMissing([
            'production_name_public' => 0,
            'project_type_id'        => ProjectTypeID::MOVIE,
            'status'                 => 1,
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectController::pending
     */
    public function can_fetch_all_pending_projects_count_using_query_string()
    {
        $user = $this->createProducer();

        factory(Project::class)->create([
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
        ]);

        factory(Project::class)->create([
            'production_name_public' => 0,
            'project_type_id'        => ProjectTypeID::MOVIE,
            'status'                 => 1,
        ]);

        $response = $this->actingAs($user, 'api')
            ->get('/api/producer/projects/pending?count=true')
            ->assertSee('Succesfully fetched all pending projects count.')
            ->assertSuccessful();

        $response->assertJsonCount(2);

        $response->assertJsonFragment([
            'count' => 1,
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectController::approved
     */
    public function can_fetch_all_approved_projects()
    {
        $this->withoutExceptionHandling();
        $user = $this->createProducer();

        factory(Project::class)->create([
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'status'                 => 1,
        ]);

        factory(Project::class)->create([
            'production_name_public' => 0,
            'project_type_id'        => ProjectTypeID::MOVIE,
            'status'                 => 0,
        ]);

        $response = $this->actingAs($user, 'api')
            ->get(route('producer.projects.approved'))
            ->assertSee('Succesfully fetched all approved projects.')
            ->assertSuccessful();

        $response->assertJsonCount(2);

        $response->assertJsonFragment([
            'project_type_id'        => ProjectTypeID::TV,
            'status'                 => 1,
        ]);

        $response->assertJsonMissing([
            'project_type_id'        => ProjectTypeID::MOVIE,
            'status'                 => 0,
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectController::approved
     */
    public function can_fetch_all_approved_projects_count_using_query_string()
    {
        $user = $this->createProducer();

        factory(Project::class)->create([
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
        ]);

        factory(Project::class)->create([
            'production_name_public' => 0,
            'project_type_id'        => ProjectTypeID::MOVIE,
            'status'                 => 1,
        ]);

        $response = $this->actingAs($user, 'api')
            ->get('/api/producer/projects/approved?count=true')
            ->assertSee('Succesfully fetched all approved projects count.')
            ->assertSuccessful();

        $response->assertJsonCount(2);

        $response->assertJsonFragment([
            'count' => 1,
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectController::store
     */
    public function can_create_a_project()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'remotes'                => [
                SiteID::CREWCALLSAMERICA,
                SiteID::CREWCALLSALASKA,
            ],
        ];

        $response = $this->actingAs($user, 'api')
            ->post(
                route('producer.project.store'),
                $data,
                [
                    'Accept' => 'application/json',
                ]
            )
            ->assertSee('Project successfully added.')
            ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('remote_projects', ['site_id' => SiteID::CREWCALLSAMERICA]);
        $this->assertDatabaseHas('remote_projects', ['site_id' => SiteID::CREWCALLSALASKA]);

        $response->assertJsonFragment(
            [
                'title'                  => 'Some Title',
                'production_name'        => 'Some Production Name',
                'production_name_public' => true,
                'project_type_id'        => ProjectTypeID::TV,
                'description'            => 'Some Description',
                'location'               => 'Some Location',
                'user_id'                => $user->id,
            ]
        );
    }

    /**
    * @test
    * @covers \App\Http\Controllers\Producer\ProjectController::update
    */
    public function can_edit_a_project()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);

        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'remotes'                => [
                SiteID::CREWCALLSAMERICA,
                SiteID::CREWCALLSALASKA,
            ],
        ];

        $response = $this->actingAs($user, 'api')
            ->put(
                route(
                    'producer.projects.update',
                    ['project' => $project->id]
                ),
                $data,
                [
                    'Accept' => 'application/json',
                ]
            )
            ->assertSee('Project successfully updated.')
            ->assertSuccessful();

        $this->assertDatabaseHas('remote_projects', ['site_id' => SiteID::CREWCALLSAMERICA]);
        $this->assertDatabaseHas('remote_projects', ['site_id' => SiteID::CREWCALLSALASKA]);

        $response->assertJsonFragment(
            [
                'title'                  => 'Some Title',
                'production_name'        => 'Some Production Name',
                'production_name_public' => true,
                'project_type_id'        => ProjectTypeID::TV,
                'description'            => 'Some Description',
                'location'               => 'Some Location',
                'user_id'                => $user->id,
            ]
        );
    }


    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectController::store
     */
    public function cannot_crate_projects_the_unauthorized_role()
    {
        $user = $this->createCrew();
        $data = [];

        $this->actingAs($user, 'api')
            ->post(
                route('producer.projects.store'),
                $data,
                [
                    'Accept' => 'application/json',
                ]
            )
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectController::store
     */
    public function cannot_create_a_project_when_required_fields_are_empty()
    {
        $user = $this->createProducer();

        $data = [
            'title'                  => '',
            'production_name'        => '',
            'production_name_public' => '',
            'project_type_id'        => '',
            'description'            => '',
        ];

        $this->actingAs($user, 'api')
            ->post(
                route('producer.project.store'),
                $data,
                [
                    'Accept' => 'application/json',
                ]
            )
            ->assertSee('The given data was invalid.')
            ->assertSee('The title field is required.')
            ->assertSee('The production name field is required.')
            ->assertSee('The production name public field is required.')
            ->assertSee('The project type id field is required.')
            ->assertSee('The description field is required.')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectController::store
     */
    public function cannot_create_a_project_when_data_is_invalid()
    {
        $user = $this->createProducer();

        $data = [
            'title'                  => false,
            'production_name'        => false,
            'production_name_public' => 'abc',
            'project_type_id'        => 'abc',
            'description'            => false,
            'location'               => false,
            'remotes'                => new \stdClass(),
        ];

        $this->actingAs($user, 'api')
            ->post(
                route('producer.project.store'),
                $data,
                [
                    'Accept' => 'application/json',
                ]
            )
            ->assertSee('The given data was invalid.')
            ->assertSee('The title must be a string.')
            ->assertSee('The title must be at least 3 characters.')
            ->assertSee('The production name must be a string.')
            ->assertSee('The production name must be at least 3 characters.')
            ->assertSee('The production name public field must be true or false.')
            ->assertSee('The project type id must be a number.')
            ->assertSee('The description must be a string.')
            ->assertSee('The description must be at least 3 characters.')
            ->assertSee('The location must be a string.')
            ->assertSee('The remotes must be an array.')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectController::update
     */
    public function cannot_edit_a_project_the_unauthorized_role()
    {
        $user = $this->createCrew();
        $data = [];

        factory(Project::class)->create();

        $this->actingAs($user, 'api')
            ->put(
                route('producer.project.update', ['project' => 1]),
                $data,
                [
                    'Accept' => 'application/json',
                ]
            )
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectController::index
     */
    public function should_include_jobs_and_remotes()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);
        $job     = [
            'persons_needed'       => '2',
            'gear_provided'        => 'Some Gear Provided',
            'gear_needed'          => 'Some Gear Needed',
            'pay_rate'             => '16',
            'pay_type_id'          => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018',
            'notes'                => 'Some Note',
            'travel_expenses_paid' => '1',
            'rush_call'            => '1',
            'position_id'          => PositionID::CAMERA_OPERATOR,
            'project_id'           => $project->id,
        ];
        $sites   = collect(1, 2, 3);

        $project->jobs()->create($job);

        $sites->each(function ($site) use ($project) {
            $project->remotes()
                ->create([
                    'site_id' => $site,
                ]);
        });

        $response = $this->actingAs($user, 'api')
            ->get(route('producer.projects.index'))
            ->assertSee('Succesfully fetched all projects.')
            ->assertSuccessful();

        $jobs = $project->jobs()->with('position')->get()->toArray();

        $response->assertJsonFragment($project->toArray());
        $response->assertJsonFragment($jobs[0]);
        $response->assertJsonFragment($project->remotes()->get()->toArray());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectController::store
     */
    public function should_still_create_a_project_without_location()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => '',
            'remotes'                => [
                SiteID::CREWCALLSAMERICA,
                SiteID::CREWCALLSALASKA,
            ],
        ];

        $response = $this->actingAs($user, 'api')
            ->post(
                route('producer.project.store'),
                $data,
                [
                    'Accept' => 'application/json',
                ]
            )
            ->assertSee('Project successfully added.')
            ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('remote_projects', ['site_id' => SiteID::CREWCALLSAMERICA]);
        $this->assertDatabaseHas('remote_projects', ['site_id' => SiteID::CREWCALLSALASKA]);

        $response->assertJsonFragment(
            [
                'title'                  => 'Some Title',
                'production_name'        => 'Some Production Name',
                'production_name_public' => true,
                'project_type_id'        => ProjectTypeID::TV,
                'description'            => 'Some Description',
                'location'               => null,
                'user_id'                => $user->id,
            ]
        );
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
