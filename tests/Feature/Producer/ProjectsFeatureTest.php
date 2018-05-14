<?php

namespace Tests\Feature\Producer;

use App\Models\Project;
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
