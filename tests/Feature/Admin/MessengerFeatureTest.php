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

    /** @test */
    public function admin_project_denied()
    {
        $admin = factory(User::class)->states('withAdminRole')->create();
        $producer = factory(User::class)->create();
        $project = factory(Project::class)->create();

        $project->owner()->associate($producer);

        $response = $this->actingAs($admin)
            ->putJson(route('admin.projects.update', $project));

        $response->assertSuccessful()
            ->assertJson([
                'message' => 'Project denied successfully.'
            ]);
    }

    /** @test */
    public function admin_project_denied_unauthorize_non_admin()
    {
        $user = factory(User::class)->states('withCrewRole')->create();
        $project = factory(Project::class)->create();

        $response = $this->actingAs($user)
            ->putJson(route('admin.projects.update', $project));

        $response->assertRedirect('/');
    }
}
