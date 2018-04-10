<?php

namespace Tests\Feature;

use App\Mail\ConfirmUserAccount;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SignupFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function crew()
    {
        Mail::fake();

        $fakerUser = factory(User::class)->make();
        $data = [
            'first_name'            => $fakerUser->first_name,
            'last_name'             => $fakerUser->last_name,
            'email'                 => $fakerUser->email,
            'email_confirmation'    => $fakerUser->email,
            'password'              => 'some_password',
            'password_confirmation' => 'some_password',
            'phone'                 => $fakerUser->phone,
            'receive_text'          => 1,
            'terms'                 => 1,
            '_token'                => csrf_token()
        ];

        Hash::shouldReceive('make')->once()->andReturn('hashed_password');

        $response = $this->post('signup/crew', $data);

        $response->assertRedirect('login');

        $this->assertDatabaseHas('users', [
            'first_name'        => $fakerUser->first_name,
            'last_name'         => $fakerUser->last_name,
            'email'             => $fakerUser->email,
            'phone'             => $fakerUser->phone,
            'password'          => 'hashed_password',
            'status'            => 1,
            'confirmed'         => 0,
        ]);

        // assert that the user has settings depending on the receive_text
        $user = User::where('email', $fakerUser->email)->first();

        $this->assertArraySubset(
            [
                'receive_email_notification' => 1,
                'receive_other_emails'       => 1,
                'receive_sms'                => 1,
            ],
            $user->notificationSettings->toArray()
        );

        // assert that the user has a crew role
        $this->assertTrue($user->hasRole(Role::CREW));

        // assert that the user is in the current site
        $site = $this->getCurrentSite();

        $this->assertTrue($user->hasSite($site->hostname));

        // assert that the user has an email confirmation token
        $this->assertNotEmpty($user->emailVerificationCode->code);

        // assert that an email has been sent for verification
        Mail::assertSent(ConfirmUserAccount::class, function($mail) use ($user) {
            return $mail->user->id === $user->id;
        });
    }

    /** @test */
    public function crew_invalid_data()
    {
        Mail::fake();

        $fakerUser = factory(User::class)->make();
        $data = [
            'first_name'            => $fakerUser->first_name,
            'last_name'             => $fakerUser->last_name,
            'email'                 => 'invalid_email',
            'email_confirmation'    => 'invalid_email',
            'password'              => 'some_password',
            'password_confirmation' => 'some_password',
            'phone'                 => $fakerUser->phone,
            'receive_text'          => 1,
            'terms'                 => 1,
            '_token'                => csrf_token()
        ];

        $response = $this->post('signup/crew', $data);

        $response->assertSessionHasErrors(['email']);
    }
}
