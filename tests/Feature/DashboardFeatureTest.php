<?php

namespace Tests\Feature;

use App\Models\User;
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
        $user = $this->createProducer();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee('Producer');

        $response->assertDontSee('View Profile');
        $response->assertDontSee('Edit Profile');
    }
}
