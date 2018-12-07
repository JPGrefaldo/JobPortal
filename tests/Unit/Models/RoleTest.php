<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRoles;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     * @covers 
     */
    public function users()
    {
        $role = Role::whereName(Role::PRODUCER)->firstOrFail();
        $user = $this->createUser();
        UserRoles::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        $this->assertEquals(1, $role->users->count());
        $this->assertEquals($user->last_name, $role->users->first()->last_name);
    }
}
