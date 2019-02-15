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

    public function test_change_to_crew_account_type()
    {
        $user = $this->createProducer();

        $this->actingAs($user)
             ->get(route('account.change-to.crew'));

        $this->assertTrue($user->hasRole(Role::CREW));
    }

    public function test_change_to_producer_account_type()
    {
        $user = $this->createCrew();

        $this->actingAs($user)
             ->get(route('account.change-to.producer'));

        $this->assertTrue($user->hasRole(Role::PRODUCER));
    }

    public function test_only_producer_can_change_to_crew_account()
    {   
        $this->expectException(UnauthorizedException::class);
        $this->disableExceptionHandling();

        $user = $this->createCrew();
        
        $this->actingAs($user)
             ->get(route('account.change-to.crew'))
             ->assertStatus(500);   
    }

    public function test_only_crew_can_change_to_producer_account()
    {   
        $this->expectException(UnauthorizedException::class);
        $this->disableExceptionHandling();

        $user = $this->createProducer();
        
        $this->actingAs($user)
             ->get(route('account.change-to.producer'))
             ->assertStatus(500);
    }
}