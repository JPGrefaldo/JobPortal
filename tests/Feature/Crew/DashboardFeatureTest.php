<?php

namespace Tests\Feature\Crew;

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
        $user = factory(User::class)->states('withCrewRole')->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee('View Profile');
        $response->assertSee('Edit Profile');

        $response->assertDontSee('Producer');
    }
}
