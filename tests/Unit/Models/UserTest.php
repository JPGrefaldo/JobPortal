<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\UserSites;
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

    /** @test */
    public function mutators()
    {
        $user = $this->createUser();

        /**
         * For phone mutations see \Tests\Unit\Utils\StrUtilsTest::format_phone
         */
        $user->update([
            'email'      => 'mYemaiL@gmaiL.com',
            'phone'      => '201-886-0269',
        ]);

        $this->assertDatabaseHas('users', [
            'id'         => $user->id,
            'email'      => 'myemail@gmail.com',
            'phone'      => '(201) 886-0269'
        ]);
    }
}
