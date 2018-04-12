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

        $fakeUser = factory(User::class)->make();
        $data = [
            'first_name'  => $fakeUser->first_name,
            'last_name'   => $fakeUser->last_name,
            'email'       => $fakeUser->email,
            'password'    => 'password',
            'phone'       => $fakeUser->phone,
            'receive_sms' => 1,
            'type'        => Role::CREW,
            '_token'      => csrf_token(),
        ];

        Hash::shouldReceive('make')->once()->andReturn('hashed_password');

        $response = $this->post('signup', $data);

        $this->assertSignupSuccess($response, $data);
    }

    /** @test */
    public function producer()
    {
        Mail::fake();

        $fakeUser = factory(User::class)->make();
        $data = [
            'first_name'  => $fakeUser->first_name,
            'last_name'   => $fakeUser->last_name,
            'email'       => $fakeUser->email,
            'password'    => 'password',
            'phone'       => $fakeUser->phone,
            'type'        => Role::PRODUCER,
            'receive_sms' => 1,
            '_token'      => csrf_token(),
        ];

        Hash::shouldReceive('make')->once()->andReturn('hashed_password');

        $response = $this->post('signup', $data);

        $this->assertSignupSuccess($response, $data);
    }

    /** @test */
    public function invalid_data()
    {
        $fakeUser = factory(User::class)->make();
        $data = [
            'first_name'  => $fakeUser->first_name,
            'last_name'   => $fakeUser->last_name,
            'email'       => 'invalid_email',
            'password'    => 'some_password',
            'phone'       => $fakeUser->phone,
            'receive_sms' => 1,
            'type'        => Role::CREW,
            '_token'      => csrf_token(),
        ];

        $response = $this->post('signup', $data);

        $response->assertSessionHasErrors(['email']);
    }

    private function assertSignupSuccess($response, $data)
    {
        $response->assertRedirect('login');

        // assert that the user has been created and had the correct user settings
        $this->assertDatabaseHas('users', [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'password'   => 'hashed_' . $data['password'],
            'status'     => 1,
            'confirmed'  => 0,
        ]);

        $user = User::where('email', $data['email'])->first();

        $this->assertArraySubset(
            [
                'receive_email_notification' => 1,
                'receive_other_emails'       => 1,
                'receive_sms'                => $data['receive_sms'] ?: 0,
            ],
            $user->notificationSettings->toArray()
        );

        // assert that the user has the correct role
        $this->assertTrue($user->hasRole($data['type']));

        // assert that the user is in the current site
        $this->assertTrue($user->sites->contains($this->getCurrentSite()));

        // assert that the user has an email confirmation token
        $this->assertNotEmpty($user->emailVerificationCode->code);

        // assert that an email has been sent for verification
        Mail::assertSent(ConfirmUserAccount::class, function($mail) use ($user) {
            return $mail->user->id === $user->id;
        });
    }
}
