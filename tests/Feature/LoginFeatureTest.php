<?php

namespace Tests\Feature;

use App\Services\UsersServices;
use App\User;
use App\UserBanned;
use Illuminate\Support\Facades\Hash;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function login()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('testpass')
        ]);
        $user->sites()->save($this->getCurrentSite());

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'testpass'
        ]);

        $this->assertAuthenticated();
    }

    /** @test */
    public function login_invalid_password()
    {
        $user = factory(User::class)->create();

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'asdasdasd'
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.'
        ]);
    }

    /** @test */
    public function login_unconfirmed()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('testpass'),
            'confirmed' => 0
        ]);

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'testpass'
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Your account is not confirmed.\n Check your email (and spam) for the confirmation link'
        ]);

        $this->assertGuest();
    }

    /** @test */
    public function login_inactive()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('testpass'),
            'status' => 0
        ]);

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'testpass'
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Your account has been closed. Please contact us for assistance in re-opening your account.'
        ]);

        $this->assertGuest();
    }

    /** @test */
    public function login_banned()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('testpass')
        ]);
        UserBanned::create([
            'user_id' => $user->id,
            'reason' => 'some reason'
        ]);

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'testpass'
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Your account has been banned. Please contact us for assistance in re-opening your account.'
        ]);

        $this->assertGuest();
    }

    /** @test */
    public function login_not_in_site()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('testpass')
        ]);
        $user->sites()->create([
            'name' => 'Some site',
            'hostname' => 'somesite.test'
        ]);

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'testpass'
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Your account is not registered in this site.'
        ]);

        $this->assertGuest();
    }
}