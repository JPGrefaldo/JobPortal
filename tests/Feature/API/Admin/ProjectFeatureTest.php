<?php

namespace Tests\Feature\API\Admin;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\Data\ProjectTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ProjectFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\API\Admin\ProjectsController::unapproved
     */
    public function should_only_return_the_unapproved_project()
    {
        factory(Project::class)->create($this->get_approved_project());
        factory(Project::class)->create($this->get_unapproved_project());

        $admin    = $this->createAdmin();
        $response = $this->actingAs($admin, 'api')
            ->get(route('admin.pending-projects'))
            ->assertSee('Successfully fetched all unapproved projects.')
            ->assertSuccessful();

        $response->assertJsonFragment(
            [
                'status' => Project::PENDING,
            ]
        );

        $response->assertJsonMissing(
            [
                'status' => Project::APPROVED,
            ]
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Admin\ProjectController::approve
     */
    public function can_approve_project()
    {
        $admin   = $this->createAdmin();
        $project = factory(Project::class)->create($this->get_unapproved_project());

        $this->assertEquals(Project::PENDING, $project->status);

        $this->actingAs($admin, 'api')
            ->putJson(route('admin.projects.approve', $project))
            ->assertSuccessful();

        $this->assertEquals(Project::APPROVED, $project->refresh()->status);
        $this->assertNull($project->refresh()->unapproved_at);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Admin\ProjectController::approve
     */
    public function can_unapprove_projects()
    {
        $admin   = $this->createAdmin();
        $project = factory(Project::class)->create($this->get_unapproved_project());

        $this->actingAs($admin, 'api')
            ->putJson(route('admin.projects.unapprove', $project))
            ->assertSee('Project unapproved successfully.')
            ->assertSuccessful();

        $this->assertEquals(Project::UNAPPROVED, $project->refresh()->status);
        $this->assertNull($project->refresh()->approved_at);
    }

    protected function get_approved_project()
    {
        return [
            'user_id'                => $this->createProducer(),
            'production_name_public' => true,
            'project_type_id'        => ProjectTypeID::MOVIE,
            'status'                 => Project::APPROVED,
            'approved_at'            => Carbon::now(),
        ];
    }

    protected function get_unapproved_project()
    {
        return [
            'user_id'                => $this->createProducer(),
            'production_name_public' => false,
            'project_type_id'        => ProjectTypeID::TV,
            'status'                 => Project::PENDING,
        ];
    }
}
