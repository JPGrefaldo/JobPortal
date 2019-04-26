<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\AddUserToSite;
use App\Models\Site;
use App\Models\UserSites;
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

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(AddUserToSite::class);
    }

    /**
     * @test
     * @covers \App\Actions\Auth\AddUserToSite::execute
     */
    public function can_add_a_user_to_a_site_they_are_not_a_member_of()
    {
        $user = $this->createUser();

        $this->assertDatabaseMissing('user_sites', [
            'user_id' => $user->id,
        ]);

        $site = factory(Site::class)->create();

        $this->service->execute($user, $site);

        $this->assertDatabaseHas('user_sites', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Auth\AddUserToSite::execute
     */
    public function returns_user_site_if_user_is_already_a_member()
    {
        $user = $this->createUser();

        $this->assertDatabaseMissing('user_sites', [
            'user_id' => $user->id,
        ]);

        $site = factory(Site::class)->create();

        $userSite = UserSites::create([
            'user_id' => $user->id,
            'site_id' => $site->id,
        ]);

        $this->assertEquals($userSite->toArray(), $this->service->execute($user, $site)->toArray());
    }
}
