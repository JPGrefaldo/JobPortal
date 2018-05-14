<?php

namespace Tests\Feature\Producer;

use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function create_unauthorized()
    {
        $user = $this->createCrewUser();

        $response = $this->actingAs($user)->post('producer/projects');

        $response->assertRedirect('/');
    }
}
