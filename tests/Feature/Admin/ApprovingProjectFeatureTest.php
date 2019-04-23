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

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\ProjectsController::index
     */
    public function should_only_return_the_unapproved_project()
    {
        $approvedProject = [
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'status'                 => 1,
            'approved_at'            => '2019-04-04 22:2=14:45',
        ];

        $unapprovedProject = [
            'production_name_public' => 0,
            'project_type_id'        => ProjectTypeID::MOVIE,
        ];

        factory(Project::class)->create($approvedProject);
        factory(Project::class)->create($unapprovedProject);

        $user = $this->createAdmin();

        $response = $this->actingAs($user)
            ->get(route('admin.projects'))
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
     * @covers \App\Http\Controllers\Admin\ProjectsController::approve
     */
    public function can_approve_projects()
    {
        $project = factory(Project::class)->create(
            [
                'production_name_public' => 1,
                'project_type_id'        => ProjectTypeID::MOVIE,
                'status'                 => 0,
            ]
        );

        $user = $this->createAdmin();

        $this->actingAs($user)
            ->put(route('admin.projects.approve', $project->id))
            ->assertSee('Project approved successfully.')
            ->assertSuccessful();

        $this->assertEquals(1, $project->refresh()->status);
    }
}
