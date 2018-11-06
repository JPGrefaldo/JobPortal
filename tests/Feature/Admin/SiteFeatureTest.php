<?php

namespace Tests\Feature\Admin;

use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class SiteFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     */
    public function index()
    {
        // given
        $admin = factory(User::class)->states('withAdminRole')->create();
        $sites = Site::all();

        // when
        $response = $this->actingAs($admin)->getJson(route('admin.sites'));

        // then
        $response->assertJson($sites->toArray());
    }
}
