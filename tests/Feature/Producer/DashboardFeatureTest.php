<?php

namespace Tests\Feature\Producer;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class DashboardFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     */
    public function see_dashboard()
    {
        // given
        $user = factory(User::class)->states('withProducerRole')->create();

        // when
        $response = $this->actingAs($user)->get(route('dashboard'));

        // then
        $response->assertSee('Producer');

        $response->assertDontSee('View Profile');
        $response->assertDontSee('Edit Profile');
    }
}
