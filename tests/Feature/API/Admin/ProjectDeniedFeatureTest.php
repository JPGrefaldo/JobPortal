<?php

namespace Tests\Feature\API\Admin;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ProjectDeniedFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\API\Admin\ProjectController::deny
     */
    public function can_deny_a_project()
    {
        $admin = $this->createAdmin();
        $project = factory(Project::class)->create();
        $data = [
            'reason' => 'Some reason',
        ];

        $this->assertNull($project->deleted_at);

        $this->actingAs($admin, 'api')
            ->postJson(route('admin.projects.deny', $project), $data)
            ->assertSee('Successfully denied the project.')
            ->assertSuccessful();

        $this->assertNotNull($project->fresh()->deleted_at);
        $this->assertCount(1, $project->deniedReason()->get());

        $this->assertArrayHas(
            [
                'body' => 'Some reason',
            ],
            $project->deniedReason()->first()->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Admin\ProjectController::deny
     */
    public function cannot_deny_a_project_without_a_reason()
    {
        $admin = $this->createAdmin();
        $project = factory(Project::class)->create();
        $data = [];

        $this->actingAs($admin, 'api')
            ->postJson(route('admin.projects.deny', $project), $data)
            ->assertSee('The given data was invalid.')
            ->assertSee('The reason field is required.')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Admin\ProjectController::deny
     */
    public function only_admin_can_deny_a_project()
    {
        $crew = $this->createCrew();
        $producer = $this->createProducer();
        $project = factory(Project::class)->create();
        $data = [];

        $this->actingAs($crew, 'api')
            ->postJson(route('admin.projects.deny', $project), $data)
            ->assertForbidden();

        $this->actingAs($producer, 'api')
            ->postJson(route('admin.projects.deny', $project), $data)
            ->assertForbidden();
    }
}
