<?php

namespace Tests\Feature\Web\Auth;

use App\Mail\ConfirmUserAccount;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class SignupFeatureTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        WithFaker;

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\UserSignupController::signup
     */
    public function crew()
    {
        Mail::fake();

        $data = $this->makeFakeUser([Role::CREW]);

        Hash::shouldReceive('make')
            ->once()
            ->andReturn('hashed_password');

        $response = $this->post(route('signup'), $data);

        $this->assertSignupSuccess($response, $data);

        $this->assertDatabaseHas('users', [
            'first_name' => $data['first_name'],
        ]);

        $user = User::whereFirstName($data['first_name'])->first();

        $this->assertDatabaseHas('user_sites', [
            'user_id' => $user->id,
        ]);

        $this->hasCrewRole($user);
        $this->hasCrew($user);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\UserSignupController::signup
     */
    public function producer()
    {
        Mail::fake();

        $data = $this->makeFakeUser([Role::PRODUCER]);

        Hash::shouldReceive('make')
            ->once()
            ->andReturn('hashed_password');

        $response = $this->post(route('signup'), $data);

        $this->assertSignupSuccess($response, $data);

        $this->assertDatabaseHas('users', [
            'first_name' => $data['first_name'],
        ]);

        $user = User::whereFirstName($data['first_name'])->first();

        $this->assertDatabaseHas('user_sites', [
            'user_id' => $user->id,
        ]);

        $this->hasProducerRole($user);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\UserSignupController::signup
     */
    public function producer_and_crew()
    {
        Mail::fake();

        $data = $this->makeFakeUser([Role::PRODUCER, Role::CREW]);

        Hash::shouldReceive('make')
            ->once()
            ->andReturn('hashed_password');

        $response = $this->post(route('signup'), $data);

        $this->assertSignupSuccess($response, $data);

        $this->assertDatabaseHas('users', [
            'first_name' => $data['first_name'],
        ]);

        $user = User::whereFirstName($data['first_name'])->first();

        $this->assertDatabaseHas('user_sites', [
            'user_id' => $user->id,
        ]);

        $this->hasCrewRole($user);
        $this->hasCrew($user);
        $this->hasProducerRole($user);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\UserSignupController::signup
     */
    public function formatted()
    {
        Mail::fake();

        $data = $this->makeFakeUser([Role::CREW], [
            'email'              => 'UPPER@gmail.com',
            'email_confirmation' => 'UPPER@gmail.com',
            'first_name'         => 'john',
            'last_name'          => 'doe',
        ]);

        Hash::shouldReceive('make')
            ->once()
            ->andReturn('hashed_password');

        $response = $this->post(route('signup'), $data);

        $this->assertSignupSuccess(
            $response,
            array_merge($data, [
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'email'      => 'upper@gmail.com',
                'phone'      => '1234567890',
            ])
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\UserSignupController::signup
     */
    public function signup_crew_no_receive_sms()
    {
        Mail::fake();

        $data = $this->makeFakeUser([Role::CREW]);

        unset($data['receive_sms']);

        Hash::shouldReceive('make')
            ->once()
            ->andReturn('hashed_password');

        $response = $this->post(route('signup'), $data);

        $this->assertSignupSuccess($response, array_merge($data, ['receive_sms' => 0]));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\UserSignupController::signup
     */
    public function signup_producer_no_receive_sms()
    {
        // $this->withoutExceptionHandling();
        Mail::fake();

        $data = $this->makeFakeUser([Role::PRODUCER]);

        unset($data['receive_sms']);

        Hash::shouldReceive('make')
            ->once()
            ->andReturn('hashed_password');

        $response = $this->post(route('signup'), $data);

        unset($data['password_confirmation']);
        unset($data['email_confirmation']);

        // if the user is a producer receive_sms is a must
        $this->assertSignupSuccess($response, array_merge($data, ['receive_sms' => 1]));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\UserSignupController::signup
     */
    public function invalid_data()
    {
        $data = $this->makeFakeUser([Role::ADMIN], [
            'email'       => 'invalid_email',
            'password'    => 'password',
            'phone'       => '+345344545446',
            'receive_sms' => 1,
        ]);

        $response = $this->post(route('signup'), $data);

        $response->assertSessionHasErrors([
            'email',
            'phone' => 'The phone must be a valid US cell phone number.',
            'type'  => 'Invalid type.',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\UserSignupController::signup
     */
    public function invalid_data_duplicate_email()
    {
        $this->createUser(['email' => 'duplicate@gmail.com']);

        $data = $this->makeFakeUser([Role::CREW], [
            'email'              => 'duplicate@gmail.com',
            'email_confirmation' => 'duplicate@gmail.com',
            'password'           => 'password',
            'receive_sms'        => 1,
        ]);

        $response = $this->post(route('signup'), $data);

        $response->assertSessionHasErrors([
            'email' => 'The email has already been taken.',
        ]);
    }

    /**
     * @param $response
     * @param $data
     */
    private function assertSignupSuccess($response, $data)
    {
        $response->assertRedirect('login');

        // assert that the user has been created and had the correct user settings
        $user = User::where('email', $data['email'])
            ->firstOrFail();

        $this->assertArrayHas(
            [
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'email'      => $data['email'],
                'phone'      => $data['phone'],
                'password'   => 'hashed_' . $data['password'],
                'status'     => 1,
                'confirmed'  => false,
            ],
            $user->makeVisible('password')
                ->toArray()
        );


        $this->assertArrayHas(
            [
                'receive_email_notification' => true,
                'receive_other_emails'       => true,
                'receive_sms'                => $data['receive_sms'],
            ],
            $user->notificationSettings->toArray()
        );

        // assert that the user has the correct role
        $this->assertTrue($user->hasRole($data['type'][0]));

        // assert that the user is in the current site
        $this->assertTrue($user->sites->contains($this->getCurrentSite()));

        // assert that the user has an email confirmation token
        $this->assertNotEmpty($user->emailVerificationCode->code);

        // assert that an email has been sent for verification
        Mail::assertSent(
            ConfirmUserAccount::class,
            function ($mail) use ($user) {
                return $mail->user->id === $user->id;
            }
        );
    }

    private function makeFakeUser($type, $values = [])
    {
        $email = $this->faker->email;

        return \Arr::recursive_combine([
            'first_name'            => $this->faker->firstName,
            'last_name'             => $this->faker->lastName,
            'phone'                 => '1234567890',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'email'                 => $email,
            'email_confirmation'    => $email,
            'receive_sms'           => 1,
            'type'                  => $type,
        ], $values);
    }

    /**
     * @param $user
     */
    public function hasCrewRole($user)
    {
        $user->hasRole(Role::CREW);
    }

    /**
     * @param $user
     */
    public function hasCrew($user)
    {
        $this->assertDatabaseHas('crews', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * @param $user
     */
    public function hasProducerRole($user)
    {
        $user->hasRole(Role::PRODUCER);
    }
}
