<?php

namespace Tests\Feature;

use App\Actions\Auth\AddUserToSite;
use App\Actions\Auth\CreateUserEmailVerificationCode;
use App\Actions\Crew\StubCrew;
use App\Models\Role;
use App\Models\User;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifyEmailFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\VerifyEmailController::verify
     */
    public function verify_email()
    {
        $user = factory(User::class)->create(['confirmed' => 0]);
        $site = $this->getCurrentSite();

        app(CreateUserEmailVerificationCode::class)->execute($user);
        app(AddUserToSite::class)->execute($user, $site);


        $response = $this->get(route('verify.email', ['code' => $user->emailVerificationCode->code]));

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

    /**
     * @test
     * @covers \App\Http\Controllers\VerifyEmailController::verify
     */
    public function verify_email_invalid_code()
    {
        $response = $this->get(route('verify.email', ['code' => 'invalid_code']));

        $response->assertRedirect('login')
                 ->assertSessionHas(
                     [
                         'flash_message' => 'Invalid confirmation code.',
                         'flash_title'   => 'Error!',
                         'flash_type'    => 'error',
                     ]
                 );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\VerifyEmailController::verify
     */
    public function verify_email_already_confirmed()
    {
        $user = $this->createUser();
        $site = $this->getCurrentSite();

        app(StubCrew::class)->execute($user);
        app(CreateUserEmailVerificationCode::class)->execute($user);
        app(AddUserToSite::class)->execute($user, $site);


        $response = $this->get(route('verify.email', ['code' => $user->emailVerificationCode->code]));

        $response->assertRedirect('login')
                 ->assertSessionHas(
                     [
                         'flash_message' => 'Your account was already confirmed, you do not need to confirm again.',
                         'flash_type'    => 'error',
                     ]
                 );
    }
}
