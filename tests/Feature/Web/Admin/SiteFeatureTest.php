<?php

namespace Tests\Feature\Admin\Web;

use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class SiteFeatureTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\SiteController::index
     */
    public function index()
    {
        $admin = $this->createAdmin();
        $sites = Site::all();

        $response = $this->actingAs($admin, 'api')->getJson(route('sites.index'));

        $response->assertJsonFragment([
            'sites' => $sites->toArray(),
        ]);
    }
}
