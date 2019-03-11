<?php

namespace Tests\Feature\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class LogoutInactiveUserFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Middleware\LogoutInactiveUser::handle
     */
    public function logout_inactive_user()
    {
        $user = $this->createUser(['status' => 0]);

        // user passes auth middleware
        $response = $this->actingAs($user)
            ->get(route('dashboard'));

        $response->assertRedirect('login')
            ->assertSessionHasErrors([
                'email' => 'Your account has been closed. Please contact us for assistance in re-opening your account.',
            ]);

        $this->assertGuest();
    }

    /**
     * @test
     * @covers \App\Http\Middleware\LogoutInactiveUser::handle
     */
    public function logout_inactive_user_through_banned()
    {
        $user = $this->createUser();

        // user passes auth middleware
        $response = $this->actingAs($user)
            ->get(route('dashboard'));

        $response->assertSuccessful();

        // ban user in admin
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)
            ->put(
                route('admin.users.ban', $user),
                ['reason' => 'some reason']
            );

        $response->assertSuccessful();

        // user is logged out when visiting home
        $user->refresh();

        $response = $this->actingAs($user)
            ->get(route('dashboard'));

        $response->assertRedirect('login')
            ->assertSessionHasErrors([
                'email' => 'Your account has been banned (some reason). Please contact us for assistance in re-opening your account.',
            ]);

        $this->assertGuest();
    }
}
