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

        $user->syncRoles(Role::PRODUCER);
        $this->assertEquals($user->roles->pluck('name')[0], Role::PRODUCER);
    }

    public function test_change_to_crew_account_type()
    {
        $this->withoutExceptionHandling();
        
        $user = $this->createUser();
        $user->assignRole(Role::PRODUCER);

        $this->actingAs($user)
             ->get(route('account.change'));

        $this->assertEquals($user->roles->pluck('name')[0], Role::CREW);
    }

    public function test_change_to_producer_account_type()
    {
        $this->withoutExceptionHandling();
        
        $user = $this->createUser();
        $user->assignRole(Role::CREW);

        $this->actingAs($user)
             ->get(route('account.change'));

        $this->assertEquals($user->roles->pluck('name')[0], Role::PRODUCER);
    }

}