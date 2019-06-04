<?php

namespace Tests\Feature\Web\Crew;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class DashboardFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\DashboardController::index
     */
    public function see_dashboard()
    {
        $user = $this->createCrew();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee('View Profile');
        $response->assertSee('Edit Profile');

        $response->assertDontSee('Producer');
    }
}
