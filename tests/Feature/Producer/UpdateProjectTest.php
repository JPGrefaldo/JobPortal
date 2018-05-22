<?php

namespace Tests\Feature\Producer;

use App\Models\Project;
use App\Models\RemoteProject;
use App\Models\Site;
use App\Models\User;
use Tests\Support\Data\ProjectTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProjectTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function update()
    {
        $user        = $this->createProducer();
        $project     = $this->createProject($user);
        $remoteSites = [
            factory(Site::class)->create()->id,
            factory(Site::class)->create()->id
        ];
        $data        = [
            'title'                  => 'Updated Title',
            'production_name'        => 'Updated Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Updated Description',
            'location'               => 'Updated Location',
            'sites'                  => $remoteSites,
        ];

        $response = $this->actingAs($user)->put('/producer/projects/' . $project->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset([
            'title'                  => 'Updated Title',
            'production_name'        => 'Updated Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Updated Description',
            'location'               => 'Updated Location',
        ], $project->refresh()->toArray());

        $this->assertCount(2, $project->remotes);
        $this->assertArraySubset([
            ['site_id' => $remoteSites[0]],
            ['site_id' => $remoteSites[1]]
        ], $project->remotes->toArray());
    }

    /** @test */
    public function update_with_existing_remotes()
    {
        $this->markTestIncomplete();

        $user        = $this->createProducer();
        $project     = $this->createProject($user);

        $project->remotes()->save(
            factory(RemoteProject::class)->make()
        );

        $remoteSites = [
            factory(Site::class)->create(),
            factory(Site::class)->create()
        ];
        $data        = [
            'title'                  => 'Updated Title',
            'production_name'        => 'Updated Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Updated Description',
            'location'               => 'Updated Location',
            'sites'                  => $remoteSites,
        ];

        $response = $this->actingAs($user)->put('/producer/projects/' . $project->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset([
            'title'                  => 'Updated Title',
            'production_name'        => 'Updated Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Updated Description',
            'location'               => 'Updated Location',
        ], $project->refresh()->toArray());

        $this->assertCount(2, $project->remotes);
        $this->assertArraySubset([
            ['site_id' => $remoteSites[0]],
            ['site_id' => $remoteSites[1]]
        ], $project->remotes->toArray());
    }

    /** @test */
    public function update_invalid()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);

        $data = [
            'title'                  => 'as',
            'production_name'        => 'as',
            'production_name_public' => 'asdasdas',
            'project_type_id'        => 999,
            'description'            => 'as',
            'location'               => '',
        ];

        $response = $this->actingAs($user)->put('/producer/projects/' . $project->id, $data);

        $response->assertSessionHasErrors([
            'title', // min 3 chars
            'production_name', // min 3 chars
            'production_name_public', // must be a boolean
            'project_type_id', // must exist on the project_types table
            'description', // min 3 chars
            'sites' // is required
        ]);
    }

    /** @test */
    public function update_unauthorized()
    {
        $user    = $this->createUser();
        $project = factory(Project::class)->create();
        $data    = [];

        $response = $this->actingAs($user)->put('/producer/projects/' . $project->id, $data);

        $response->assertRedirect('/');
    }

    /** @test */
    public function update_unauthorized_user()
    {
        $user    = $this->createProducer();
        $project = factory(Project::class)->create();
        $data    = [];

        $response = $this->actingAs($user)->put('/producer/projects/' . $project->id, $data);

        $response->assertForbidden();
    }

    /** @test */
    public function update_unauthorized_nonexisting_project()
    {
        $user = $this->createProducer();
        $data = [];

        $response = $this->actingAs($user)->put('/producer/projects/' . 999, $data);

        $response->assertNotFound();
    }

    /**
     * @param \App\Models\User $user
     * @param array            $attributes
     *
     * @return \App\Models\Project
     */
    private function createProject(User $user, $attributes = [])
    {
        $attributes['user_id'] = $user->id;
        $attributes['site_id'] = $this->getCurrentSite()->id;

        return factory(Project::class)->create($attributes);
    }
}
