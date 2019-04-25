<?php

namespace Tests\Feature\Admin\Web;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\Support\Data\ProjectTypeID;
use Tests\TestCase;
use Carbon\Carbon;

class ApproveProjectFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    protected function getApprovedProject()
    {
        return [
            'user_id'                => $this->createProducer(),
            'production_name_public' => true,
            'project_type_id'        => ProjectTypeID::TV,
            'status'                 => Project::APPROVED,
            'approved_at'            => '2019-04-04 22:14:45',
        ];
    }

    protected function getUnapprovedProject()
    {
        return [
            'user_id'                => $this->createProducer(),
            'production_name_public' => false,
            'project_type_id'        => ProjectTypeID::MOVIE,
            'status'                 => Project::UNAPPROVED,
        ];
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\ProjectsController::index
     */
    public function should_only_return_the_unapproved_project()
    {
        factory(Project::class)->create($this->getApprovedProject());
        factory(Project::class)->create($this->getUnapprovedProject());

        $user = $this->createAdmin();

        $response = $this->actingAs($user, 'api')
            ->get(route('admin.projects.unapproved'))
            ->assertSee('Succesfully fetched all projects.')
            ->assertSuccessful();

        $response->assertJsonFragment(
            [
                'production_name_public' => false,
                'project_type_id'        => ProjectTypeID::MOVIE,
                'status'                 => Project::UNAPPROVED,
            ]
        );
        $response->assertJsonMissing(
            [
                'production_name_public' => true,
                'project_type_id'        => ProjectTypeID::TV,
                'status'                 => Project::APPROVED,
                'approved_at'            => '2019-04-04 22:14:45',
            ]
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\ProjectController
     */
    public function only_admin_can_see_unapproved_projects_page()
    {
        $this->actingAs($this->createAdmin())
            ->get(route('admin.projects'))
            ->assertSuccessful();

        $this->actingAs($this->createCrew())
            ->get(route('admin.projects'))
            ->assertForbidden();

        $this->actingAs($this->createProducer())
            ->get(route('admin.projects'))
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\ProjectController::approve
     */
    public function can_approve_project()
    {
        $admin = $this->createAdmin();

        $project = factory(Project::class)->create($this->getUnapprovedProject());

        $this->assertEquals(Project::UNAPPROVED, $project->status);

        $this->actingAs($admin)
            ->put(route('admin.projects.approve', $project->id))
            ->assertOk();

        $this->assertEquals(Project::APPROVED, $project->refresh()->status);
        $this->assertEquals(Carbon::now(), $project->refresh()->approved_at);
        $this->assertNull($project->refresh()->unapproved_at);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\ProjectController::approve
     */
    public function can_unapprove_projects()
    {
        $project = factory(Project::class)->create($this->getUnapprovedProject());

        $this->actingAs($this->createAdmin())
            ->put(route('admin.projects.unapprove', $project->id))
            ->assertSee('Project unapproved successfully.')
            ->assertSuccessful();

        $this->assertEquals(Project::UNAPPROVED, $project->refresh()->status);
        $this->assertNull($project->refresh()->approved_at);
        $this->assertEquals(Carbon::now(), $project->refresh()->unapproved_at);
    }
}
