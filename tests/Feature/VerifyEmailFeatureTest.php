<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Services\AuthServices;
use App\Models\User;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifyEmailFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function verify_email()
    {
        $user = factory(User::class)->create(['confirmed' => 0]);
        $site = $this->getCurrentSite();
        app(AuthServices::class)->createByRoleName(Role::CREW, $user, $site);

        $response = $this->get('verify/email/' . $user->emailVerificationCode->code);

        $response->assertRedirect('login')
            ->assertSessionHas(
                [
                    'flash_message' => 'Your account has been confirmed! You may now login.',
                    'flash_type'    => 'success',
                ]
            );

        $this->assertDatabaseHas('users', [
            'id'        => $user->id,
            'confirmed' => 1,
        ]);
    }

    /** @test */
    public function verify_email_invalid_code()
    {
        $response = $this->get('verify/email/invalid_code');

        $response->assertRedirect('login')
            ->assertSessionHas(
                [
                    'flash_message' => 'Invalid confirmation code.',
                    'flash_title'   => 'Error!',
                    'flash_type'    => 'error',
                ]
            );
    }

    /** @test */
    public function verify_email_already_confirmed()
    {
        $user = factory(User::class)->create();
        $site = $this->getCurrentSite();
        app(AuthServices::class)->createByRoleName(
            Role::CREW,
            $user,
            $site
        );

        $response = $this->get('verify/email/' . $user->emailVerificationCode->code);

        $response->assertRedirect('login')
            ->assertSessionHas(
                [
                    'flash_message' => 'Your account was already confirmed, you do not need to confirm again.',
                    'flash_type'    => 'error',
                ]
            );
    }
}
