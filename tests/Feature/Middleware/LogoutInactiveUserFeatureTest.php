<?php

namespace Tests\Feature\Middleware;

use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutInactiveUserFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function logout_inactive_user()
    {
        $user = $this->createUser(['status' => 0]);

        // user passes auth middleware
        $response = $this->actingAs($user)->get('home');

        $response->assertRedirect('login')
            ->assertSessionHasErrors([
                'email' => 'Your account has been closed. Please contact us for assistance in re-opening your account.'
            ]);

        $this->assertGuest();
    }

    /** @test */
    public function logout_inactive_user_through_banned()
    {
        $user = $this->createUser();

        // user passes auth middleware
        $response = $this->actingAs($user)->get('home');

        $response->assertSuccessful();

        // ban user in admin
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->put(
            'admin/users/ban/' . $user->id,
            ['reason' => 'some reason']
        );

        $response->assertSuccessful();

        // user is logged out when visiting home
        $user->refresh();

        $response = $this->actingAs($user)->get('home');

        $response->assertRedirect('login')
            ->assertSessionHasErrors([
                'email' => 'Your account has been banned (some reason). Please contact us for assistance in re-opening your account.'
            ]);

        $this->assertGuest();
    }
}
