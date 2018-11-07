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
     */
    public function create()
    {
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();

        // when
        $response = $this->actingAs($producer)->get(route('producer.projects.create'));

        // then
        $response->assertSee('Post your project');
        $response->assertSee('Project title:');
        $response->assertSee('Production company name (or your name if individual)');
        $response->assertSee('Show my production company name publicly?');
        $response->assertSee('Project type:');
    }
}
