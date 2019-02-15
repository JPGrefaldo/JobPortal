<?php

namespace Tests\Feature\Crews;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewAbilityToAddOtherAccountTypeTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function test_changing_account_type()
    {
        $user = $this->createUser();

        $user->assignRole(Role::CREW);
        $this->assertEquals($user->roles->pluck('name')[0], Role::CREW);

        $user->syncRoles(Role::PRODUCER);
        $this->assertEquals($user->roles->pluck('name')[0], Role::PRODUCER);
    }

    public function test_change_to_crew_account_type()
    {
        $user = $this->createProducer();
        $user->assignRole(Role::PRODUCER);

        $this->actingAs($user)
             ->get(route('account.change-to.crew'));

        $this->assertEquals($user->roles->pluck('name')[0], Role::CREW);
    }

    public function test_change_to_producer_account_type()
    {
        $user = $this->createCrew();
        $user->assignRole(Role::CREW);

        $this->actingAs($user)
             ->get(route('account.change-to.producer'));

        $this->assertEquals($user->roles->pluck('name')[0], Role::PRODUCER);
    }

    public function test_only_producer_can_change_to_crew_account()
    {   
        $this->expectException(UnauthorizedException::class);
        $this->disableExceptionHandling();

        $user = $this->createCrew();
        $user->assignRole(Role::CREW);
        
        $this->actingAs($user)
             ->get(route('account.change-to.crew'))
             ->assertStatus(500);   
    }

    public function test_only_crew_can_change_to_producer_account()
    {   
        $this->expectException(UnauthorizedException::class);
        $this->disableExceptionHandling();

        $user = $this->createProducer();
        $user->assignRole(Role::PRODUCER);
        
        $this->actingAs($user)
             ->get(route('account.change-to.producer'))
             ->assertStatus(500);
        
    }
}