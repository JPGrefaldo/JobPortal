<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserBanned;
use Illuminate\Support\Facades\Hash;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\LoginController::login
     */
    public function login()
    {
        $user = $this->createUser([
            'password' => Hash::make('testpass'),
        ]);
        $user->sites()->save($this->getCurrentSite());

        $response = $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'testpass',
        ]);

        $this->assertAuthenticated();

        $response->assertSessionHas('api-token');

        $this->assertGreaterThan(250, strlen(session('api-token')));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\LoginController::login
     */
    public function login_invalid_password()
    {
        $user = $this->createUser();

        $response = $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'asdasdasd',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\LoginController::login
     */
    public function login_unconfirmed()
    {
        $user = $this->createUser([
            'password'  => Hash::make('testpass'),
            'confirmed' => 0,
        ]);

        $response = $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'testpass',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Your account is not confirmed.\n Check your email (and spam) for the confirmation link',
        ]);

        $this->assertGuest();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\LoginController::login
     */
    public function login_inactive()
    {
        $user = $this->createUser([
            'password' => Hash::make('testpass'),
            'status'   => 0,
        ]);

        $response = $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'testpass',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Your account has been closed. Please contact us for assistance in re-opening your account.',
        ]);

        $this->assertGuest();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\LoginController::login
     */
    public function login_banned()
    {
        $user = $this->createUser([
            'password' => Hash::make('testpass'),
        ]);
        UserBanned::create([
            'user_id' => $user->id,
            'reason'  => 'some reason',
        ]);

        $response = $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'testpass',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Your account has been banned. Please contact us for assistance in re-opening your account.',
        ]);

        $this->assertGuest();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\LoginController::login
     */
    public function login_not_in_site()
    {
        $user = $this->createUser([
            'password' => Hash::make('testpass'),
        ]);
        $user->sites()
            ->create([
                'name'     => 'Some site',
                'hostname' => 'somesite.test',
            ]);

        $response = $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'testpass',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Your account is not registered in this site.',
        ]);

        $this->assertGuest();
    }
}
