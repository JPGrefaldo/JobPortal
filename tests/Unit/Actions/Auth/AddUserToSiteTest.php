<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\AddUserToSite;
use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

/**
 * @group AddUserToSiteTest
 */
class AddUserToSiteTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var AddUserToSite
     */
    public $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(AddUserToSite::class);
    }

    /**
     * @test
     * @covers \App\Actions\Auth\AddUserToSite::execute
     */
    public function execute()
    {
        $user = factory(User::class)->create();

        $this->assertDatabaseMissing('user_sites', [
            'user_id' => $user->id,
        ]);

        $this->service->execute($user, Site::whereHostname('crewcalls.test')->first());

        $this->assertDatabaseHas('user_sites', [
            'user_id' => $user->id,
        ]);
    }
}
