<?php

namespace Tests\Feature\Admin\Web;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class MessengerFeatureTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\ProjectController::update
     */
    public function admin_project_denied()
    {
        $admin = $this->createAdmin();
        $producer = $this->createProducer();
        $project = factory(Project::class)->create();

        $project->owner()->associate($producer);

        $response = $this->actingAs($admin)
            ->putJson(route('admin.projects.update', $project));

        $response->assertSuccessful()
            ->assertJson([
                'message' => 'Project denied successfully.',
            ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\ProjectController::update
     */
    public function admin_project_denied_unauthorized_non_admin()
    {
        $user = $this->createCrew();
        $project = factory(Project::class)->create();

        $response = $this->actingAs($user)
            ->putJson(route('admin.projects.update', $project));

        $response->assertForbidden();
    }
}
