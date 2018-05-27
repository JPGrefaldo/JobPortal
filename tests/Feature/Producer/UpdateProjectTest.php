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
        $remoteSites = factory(Site::class, 2)->create();
        $data        = [
            'title'                  => 'Updated Title',
            'production_name'        => 'Updated Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Updated Description',
            'location'               => 'Updated Location',
            'sites'                  => [
                $remoteSites[0]->id,
                $remoteSites[1]->id,
            ],
        ];

        $response = $this->actingAs($user)
                         ->put('/producer/projects/' . $project->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset([
                'title'                  => 'Updated Title',
                'production_name'        => 'Updated Production Name',
                'production_name_public' => 1,
                'project_type_id'        => ProjectTypeID::TV,
                'description'            => 'Updated Description',
                'location'               => 'Updated Location',
            ],
            $project->refresh()
                    ->toArray()
        );

        $this->assertCount(2, $project->remotes);
        $this->assertArraySubset([
                ['site_id' => $remoteSites[0]->id],
                ['site_id' => $remoteSites[1]->id],
            ],
            $project->remotes->toArray()
        );
    }

    /** @test */
    public function update_no_location()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);
        $data    = [
            'title'                  => 'Updated Title',
            'production_name'        => 'Updated Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Updated Description',
            'location'               => '',
            'sites'                  => [],
        ];

        $response = $this->actingAs($user)
                         ->put('/producer/projects/' . $project->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset([
                'title'                  => 'Updated Title',
                'production_name'        => 'Updated Production Name',
                'production_name_public' => 1,
                'project_type_id'        => ProjectTypeID::TV,
                'description'            => 'Updated Description',
                'location'               => null,
            ],
            $project->refresh()
                    ->toArray()
        );
    }

    /** @test */
    public function update_remotes_does_not_include_current_site()
    {
        $user        = $this->createProducer();
        $project     = $this->createProject($user);
        $remoteSites = factory(Site::class, 2)->create();
        $data        = [
            'title'                  => 'Updated Title',
            'production_name'        => 'Updated Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Updated Description',
            'location'               => 'Updated Location',
            'sites'                  => [
                $this->getCurrentSite()->id,
                $remoteSites[0]->id,
                $remoteSites[1]->id,
            ],
        ];

        $response = $this->actingAs($user)
                         ->put('/producer/projects/' . $project->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset([
                'title'                  => 'Updated Title',
                'production_name'        => 'Updated Production Name',
                'production_name_public' => 1,
                'project_type_id'        => ProjectTypeID::TV,
                'description'            => 'Updated Description',
                'location'               => 'Updated Location',
            ],
            $project->refresh()
                    ->toArray()
        );

        $this->assertCount(2, $project->remotes);
        $this->assertArraySubset([
                ['site_id' => $remoteSites[0]->id],
                ['site_id' => $remoteSites[1]->id],
            ],
            $project->remotes->toArray()
        );
    }

    /** @test */
    public function update_with_existing_remotes()
    {
        $user          = $this->createProducer();
        $project       = $this->createProject($user);
        $remoteProject = factory(RemoteProject::class)->create(['project_id' => $project->id]);
        $remoteSites   = factory(Site::class, 2)->create();
        $data          = [
            'title'                  => 'Updated Title',
            'production_name'        => 'Updated Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Updated Description',
            'location'               => 'Updated Location',
            'sites'                  => [
                $remoteProject->site_id,
                $remoteSites[0]->id,
                $remoteSites[1]->id,
            ],
        ];

        $response = $this->actingAs($user)
                         ->put('/producer/projects/' . $project->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset([
                'title'                  => 'Updated Title',
                'production_name'        => 'Updated Production Name',
                'production_name_public' => 1,
                'project_type_id'        => ProjectTypeID::TV,
                'description'            => 'Updated Description',
                'location'               => 'Updated Location',
            ],
            $project->refresh()
                    ->toArray()
        );

        $this->assertCount(3, $project->remotes);
        $this->assertArraySubset([
                ['site_id' => $remoteProject->site_id],
                ['site_id' => $remoteSites[0]->id],
                ['site_id' => $remoteSites[1]->id],
            ],
            $project->remotes->toArray()
        );
    }

    /** @test */
    public function update_remove_all_existing_remotes()
    {
        $user           = $this->createProducer();
        $project        = $this->createProject($user);
        $remoteProjects = factory(RemoteProject::class, 2)->create(['project_id' => $project->id]);
        $data           = [
            'title'                  => 'Updated Title',
            'production_name'        => 'Updated Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Updated Description',
            'location'               => 'Updated Location',
            'sites'                  => [],
        ];

        $response = $this->actingAs($user)
                         ->put('/producer/projects/' . $project->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset([
                'title'                  => 'Updated Title',
                'production_name'        => 'Updated Production Name',
                'production_name_public' => 1,
                'project_type_id'        => ProjectTypeID::TV,
                'description'            => 'Updated Description',
                'location'               => 'Updated Location',
            ],
            $project->refresh()
                    ->toArray()
        );

        $this->assertCount(0, $project->remotes);
    }

    /** @test */
    public function update_invalid_required()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);
        $data    = [
            'title'                  => '',
            'production_name'        => '',
            'production_name_public' => '',
            'project_type_id'        => '',
            'description'            => '',
            'location'               => '',
        ];

        $response = $this->actingAs($user)
                         ->put('/producer/projects/' . $project->id, $data);

        $response->assertSessionHasErrors([
            'title',
            'production_name',
            'production_name_public',
            'project_type_id',
            'description',
            'sites',
        ]);
    }

    /** @test */
    public function update_invalid_data()
    {
        $user    = $this->createProducer();
        $project = $this->createProject($user);
        $data    = [
            'title'                  => 'as',
            'production_name'        => 'as',
            'production_name_public' => 'asdasdas',
            'project_type_id'        => 999,
            'description'            => 'as',
            'location'               => '',
            'sites'                  => [
                998,
                999,
            ],
        ];

        $response = $this->actingAs($user)
                         ->put('/producer/projects/' . $project->id, $data);

        $response->assertSessionHasErrors([
            'title', // min 3 chars
            'production_name', // min 3 chars
            'production_name_public', // must be a boolean
            'project_type_id', // must exist on the project_types table
            'description', // min 3 chars
            'sites.*' // must exist on the sites table
        ]);
    }

    /** @test */
    public function update_unauthorized()
    {
        $user    = $this->createUser();
        $project = factory(Project::class)->create();
        $data    = [];

        $response = $this->actingAs($user)
                         ->put('/producer/projects/' . $project->id, $data);

        $response->assertRedirect('/');
    }

    /** @test */
    public function update_unauthorized_user()
    {
        $user    = $this->createProducer();
        $project = factory(Project::class)->create();
        $data    = [];

        $response = $this->actingAs($user)
                         ->put('/producer/projects/' . $project->id, $data);

        $response->assertForbidden();
    }

    /** @test */
    public function update_unauthorized_nonexisting_project()
    {
        $user = $this->createProducer();
        $data = [];

        $response = $this->actingAs($user)
                         ->put('/producer/projects/' . 999, $data);

        $response->assertNotFound();
    }

    /**
     * @param \App\Models\User $user
     * @param array $attributes
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
