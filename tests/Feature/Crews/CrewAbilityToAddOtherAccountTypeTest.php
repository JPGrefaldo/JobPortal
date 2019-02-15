<?php

namespace Tests\Feature\Crews;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewAbilityToAddOtherAccountTypeTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function test_change_account_type()
    {
        $user = $this->createUser();

        $user->assignRole(Role::CREW);
        $this->assertEquals($user->roles->pluck('name')[0], Role::CREW);

        $user->removeRole(Role::CREW);

        $user->assignRole(Role::PRODUCER);
        $this->assertEquals($user->roles->pluck('name')[0], Role::PRODUCER);
    }

}