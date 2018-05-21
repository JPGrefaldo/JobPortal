<?php

namespace Tests\Feature\Producer;

use App\Models\Project;
use App\Models\User;
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
        /** @temp */
        $user = $this->createProducer();
        $project = factory(Project::class)->create(['user_id' => $user->id]);
        $data = [];

        $response = $this->actingAs($user)->put('/producer/projects/' . $project->id, $data);

        $response->assertSuccessful();
    }

    /** @test */
    public function update_unauthorized()
    {
        $user = $this->createUser();
        $project = factory(Project::class)->create();
        $data = [];

        $response = $this->actingAs($user)->put('/producer/projects/' . $project->id, $data);

        $response->assertRedirect('/');
    }

    /** @test */
    public function update_unauthorized_user()
    {
        $user = $this->createProducer();
        $project = factory(Project::class)->create();
        $data = [];

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
}
