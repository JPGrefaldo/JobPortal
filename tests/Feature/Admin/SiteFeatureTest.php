<?php

namespace Tests\Feature\Admin;

use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesModels;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class SiteFeatureTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        CreatesModels;

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\SiteController::index
     */
    public function index()
    {
        $admin = $this->createAdmin();
        $sites = Site::all();

        $response = $this->actingAs($admin)->getJson(route('admin.sites'));

        $response->assertJson($sites->toArray());
    }
}
