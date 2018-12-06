<?php

namespace Tests\Feature\Producer;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CreateProjectFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectsController::create
     */
    public function create()
    {
        $producer = $this->createProducer();

        $response = $this->actingAs($producer)->get(route('producer.projects.create'));

        $response->assertSee('Post your project');
        $response->assertSee('Project title:');
        $response->assertSee('Production company name (or your name if individual)');
        $response->assertSee('Show my production company name publicly?');
        $response->assertSee('Project type:');
    }
}
