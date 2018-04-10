<?php

namespace Tests\Unit\Services;

use App\Role;
use App\User;
use App\UserRoles;
use App\UserSites;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function roles()
    {
        $role = Role::whereName(Role::PRODUCER)->firstOrFail();
        $user = factory(User::class)->create();
        UserRoles::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        $this->assertEquals(1, $user->roles->count());
        $this->assertEquals("Producer", $user->roles->first()->name);
    }

    /** @test */
    public function sites()
    {
        $user = factory(User::class)->create();
        $site = $this->getCurrentSite();
        UserSites::create([
            'user_id' => $user->id,
            'site_id' => $site->id,
        ]);

        $this->assertEquals(1, $user->sites->count());
        $this->assertEquals($site->name, $user->sites->first()->name);
    }
}
