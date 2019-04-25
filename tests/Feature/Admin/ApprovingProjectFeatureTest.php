<?php

namespace Tests\Feature\Producer;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\Support\Data\ProjectTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ApprovingProjectFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    protected function getApprovedProject()
    {
        return [
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'status'                 => 1,
            'approved_at'            => '2019-04-04 22:2=14:45',
        ];
    }

    protected function getUnapprovedProject()
    {
        return [
            'production_name_public' => 0,
            'project_type_id'        => ProjectTypeID::MOVIE,
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
            ->get(route('admin.pending-projects'))
            ->assertSee('Succesfully fetched all projects.')
            ->assertSuccessful();

        $response->assertJsonFragment(
            [
                'production_name_public' => false,
                'project_type_id'        => ProjectTypeID::MOVIE,
                'status'                 => 0,
            ]
        );
        $response->assertJsonMissing(
            [
                'production_name_public' => true,
                'project_type_id'        => ProjectTypeID::TV,
                'status'                 => 1,
                'approved_at'            => '2019-04-04 22:2=14:45',
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
     * @covers \App\Http\Controllers\Admin\ProjectsController::approve
     */
    public function can_approve_projects()
    {
        $project = factory(Project::class)->create($this->getUnapprovedProject());

        $this->actingAs($this->createAdmin())
            ->put(route('admin.projects.approve', $project->id))
            ->assertSee('Project approved successfully.')
            ->assertSuccessful();

        $this->assertEquals(1, $project->refresh()->status);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\ProjectsController::approve
     */
    public function can_unapprove_projects()
    {
        $project = factory(Project::class)->create($this->getUnapprovedProject());

        $this->actingAs($this->createAdmin())
            ->put(route('admin.projects.unapprove', $project->id))
            ->assertSee('Project unapproved successfully.')
            ->assertSuccessful();

        $this->assertEquals(2, $project->refresh()->status);
    }
}
