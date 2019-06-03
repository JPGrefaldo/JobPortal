<?php

namespace Tests\Feature\Web\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\LoginController::logout
     */
    public function logout()
    {
        $user = $this->createCrew();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertSessionMissing('_token')
            ->assertRedirect('/');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\LoginController::logout
     */
    public function unauthorize_guest()
    {
        $response = $this->post(route('logout'));

        $response->assertRedirect('/');
    }
}
