<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Models\UserSites;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiteTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function users()
    {
        $site = $this->getCurrentSite();
        $user = factory(User::class)->create();
        UserSites::create([
            'user_id' => $user->id,
            'site_id' => $site->id,
        ]);

        $this->assertEquals(1, $site->users->count());
        $this->assertEquals($user->last_name, $site->users->first()->last_name);
    }
}
