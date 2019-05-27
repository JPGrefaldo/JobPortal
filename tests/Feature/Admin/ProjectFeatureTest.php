<?php

namespace Tests\Feature\Admin;

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
}
