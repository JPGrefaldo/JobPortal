<?php

namespace Tests\Feature\Admin\Web;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ApproveProjectFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\ProjectController::approve
     */
    public function can_approve_project()
    {
        $admin    = $this->createAdmin();
        $producer = $this->createProducer();

        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $this->assertEquals(0, $project->status);

        $this->actingAs($admin)
            ->get(route('admin.projects.approve', $project->id))
            ->assertOk();

        $this->assertEquals(1, $project->refresh()->status);
    }
}
