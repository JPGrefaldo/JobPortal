<?php

namespace Tests\Feature\Admin;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class MessengerFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;
    /**
     * @test
     */
    public function producer_is_messaged_when_project_is_denied()
    {
        // given
        $admin = factory(User::class)->states('withAdminRole')->create();
        $producer = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $project->owner()->associate($producer);

        // when
        $response = $this
            ->actingAs($admin)
            ->putJson(route('admin.projects.update', $project));

        // then
        $response->assertSee('Project denied successfully.');
    }
}
