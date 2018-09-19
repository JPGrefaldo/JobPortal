<?php

namespace Tests\Feature\User;

use App\Models\UserNotificationSetting;
use Illuminate\Support\Facades\Hash;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSettingsFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\User\UserSettingsController::updateName
     */
    public function update_name()
    {
        $user = $this->createUser();
        $data = [
            'first_name' => 'Adam James',
            'last_name'  => 'Ford',
        ];

        $this->actingAs($user)
            ->get(route('account.name'));

        $response = $this->actingAs($user)
                         ->post(route('account.name'), $data);

        $response->assertRedirect(route('account.name'));

        $this->assertArraySubset([
                'first_name' => 'Adam James',
                'last_name'  => 'Ford',
            ],
            $user->refresh()
                 ->toArray()
        );
    }

    /** @test */
    public function update_name_formatted()
    {
        $user = $this->createUser();
        $data = [
            'first_name' => 'JoHn jAMES',
            'last_name'  => "O'neal",
        ];

        $this->actingAs($user)
            ->get(route('account.name'));

        $response = $this->actingAs($user)
                         ->post(route('account.name'), $data);

        $response->assertRedirect(route('account.name'));

        $this->assertArraySubset([
                'first_name' => 'John James',
                'last_name'  => "O'Neal",
            ],
            $user->refresh()
                 ->toArray()
        );
    }

    /** @test */
    public function update_name_invalid_data()
    {
        $user = $this->createUser();
        $data = [
            'first_name' => '123 Robot',
            'last_name'  => '2543',
        ];

        $this->actingAs($user)
            ->get(route('account.name'));

        $response = $this->actingAs($user)
                         ->post(route('account.name'), $data);

        $response->assertSessionHasErrors([
            'first_name', // a-z'- and space chars are only allowed
            'last_name' // a-z- and space chars are only allowed
        ]);
    }

    /** @test */
    public function update_notifications()
    {
        $user = $this->createUser();
        factory(UserNotificationSetting::class)->create([
            'user_id'     => $user->id,
            'receive_sms' => 0,
        ]);

        $data = [
            'email'                      => 'updateemail@gmail.com',
            'email_confirmation'         => 'updateemail@gmail.com',
            'phone'                      => '1234567890',
            'receive_email_notification' => 1,
            'receive_other_emails'       => 1,
            'receive_sms'                => 1,
        ];

        $response = $this->actingAs($user)
                         ->put('/account/settings/notifications', $data);

        $response->assertSuccessful();

        $user->refresh();

        $this->assertArraySubset([
                'email' => 'updateemail@gmail.com',
                'phone' => '1234567890',
            ],
            $user->toArray()
        );

        $this->assertArraySubset([
                'receive_email_notification' => true,
                'receive_other_emails'       => true,
                'receive_sms'                => true,
            ],
            $user->notificationSettings->toArray()
        );
    }

    /** @test */
    public function update_notifications_same_data()
    {
        $user = $this->createUser([
            'email' => 'safe@gmail.com',
            'phone' => '1234567890',
        ]);

        factory(UserNotificationSetting::class)->create([
            'user_id'                    => $user->id,
            'receive_email_notification' => 1,
            'receive_other_emails'       => 1,
            'receive_sms'                => 1,
        ]);

        $data = [
            'email'                      => $user->email,
            'email_confirmation'         => $user->email,
            'phone'                      => $user->phone,
            'receive_email_notification' => 1,
            'receive_other_emails'       => 1,
            'receive_sms'                => 1,
        ];

        $response = $this->actingAs($user)
                         ->put('/account/settings/notifications', $data);

        $response->assertSuccessful();

        $user->refresh();

        $this->assertArraySubset([
                'email' => 'safe@gmail.com',
                'phone' => '1234567890',
            ],
            $user->toArray()
        );

        $this->assertArraySubset([
                'receive_email_notification' => true,
                'receive_other_emails'       => true,
                'receive_sms'                => true,
            ],
            $user->notificationSettings->toArray()
        );
    }

    /** @test */
    public function update_notifications_disable_all()
    {
        $user = $this->createUser([
            'email' => 'safe@gmail.com',
        ]);

        factory(UserNotificationSetting::class)->create([
            'user_id'     => $user->id,
            'receive_sms' => 0,
        ]);

        $data = [
            'email' => $user->email,
            'phone' => $user->phone,
            'email_confirmation'   => 'safe@gmail.com',
        ];

        $response = $this->actingAs($user)
                         ->put('/account/settings/notifications', $data);

        $this->assertArraySubset([
                'receive_email_notification' => false,
                'receive_other_emails'       => false,
                'receive_sms'                => false,
            ],
            $user->notificationSettings->toArray()
        );
    }

    /** @test */
    public function update_notifications_only_receive_other_emails()
    {
        $user = $this->createUser([
            'email'          => 'safe@gmail.com',
        ]);

        factory(UserNotificationSetting::class)->create([
            'user_id'     => $user->id,
            'receive_sms' => false,
        ]);

        $data = [
            'email'                => $user->email,
            'phone'                => $user->phone,
            'receive_other_emails' => true,
            'email_confirmation'   => 'safe@gmail.com',
        ];
        $response = $this->actingAs($user)
                         ->put('/account/settings/notifications', $data);

        $user->refresh();
        $user->notificationSettings->refresh();

        $this->assertArraySubset([
                'receive_email_notification' => 0,
                'receive_other_emails'       => 1,
                'receive_sms'                => 0,
            ],
            $user->notificationSettings->toArray()
        );
    }

    /** @test */
    public function update_notifications_format_user_details()
    {
        $user = $this->createUser();

        factory(UserNotificationSetting::class)->create([
            'user_id' => $user->id,
        ]);

        $data = [
            'email' => 'UPPER@gmail.com',
            'email_confirmation'   => 'UPPER@gmail.com',
            'phone' => '123.456.7890',
        ];

        $response = $this->actingAs($user)
                         ->put('/account/settings/notifications', $data);

        $response->assertSuccessful();

        $this->assertArraySubset([
                'email' => 'upper@gmail.com',
                'phone' => '1234567890',
            ],
            $user->refresh()
                 ->toArray()
        );

        $this->assertArraySubset([
                'receive_email_notification' => false,
                'receive_other_emails'       => false,
                'receive_sms'                => false,
            ],
            $user->notificationSettings->toArray()
        );
    }

    /** @test */
    public function update_notifications_invalid_data()
    {
        $user = $this->createUser();

        factory(UserNotificationSetting::class)->create([
            'user_id'     => $user->id,
            'receive_sms' => 0,
        ]);

        $data = [
            'email'                      => 'invalid@mail.test',
            'phone'                      => '+6012-705 3767',
            'receive_email_notification' => 'asdasd',
            'receive_other_emails'       => 'asdasd',
            'receive_sms'                => 'asdasd',
        ];

        $response = $this->actingAs($user)
                         ->put('/account/settings/notifications', $data);

        $response->assertSessionHasErrors([
            'email' => 'The email must be a valid email address.',
            'phone' => 'The phone must be a valid US cell phone number.',
            'receive_email_notification',
            'receive_other_emails',
            'receive_sms',
        ]);
    }

    /** @test */
    public function update_notifications_existing_email()
    {
        // arrange
        $user = $this->createUser();

        factory(UserNotificationSetting::class)->create([
            'user_id'     => $user->id,
            'receive_sms' => 0,
        ]);

        $this->createUser(['email' => 'existingemail@gmail.com']);

        $data = [
            'email'                      => 'existingemail@gmail.com',
            'email_confirmation'         => 'existingemail@gmail.com',
            'phone'                      => $user->phone,
            'receive_email_notification' => 1,
            'receive_other_emails'       => 1,
            'receive_sms'                => 1,
        ];

        $response = $this->actingAs($user)
                         ->put('/account/settings/notifications', $data);

        $response->assertSessionHasErrors([
            'email' => 'The email has already been taken.',
        ]);
    }

    /** @test */
    public function update_password()
    {
        $user = $this->createUser(['password' => Hash::make('current_password')]);
        $data = [
            'current_password'      => 'current_password',
            'password'              => 'new_password',
            'password_confirmation' => 'new_password',
        ];

        Hash::shouldReceive('make')
            ->once()
            ->andReturn('hashed_new_password');
        Hash::makePartial();

        $response = $this->actingAs($user)
                         ->put('/account/settings/password', $data);

        $response->assertSuccessful();

        $user->refresh();

        $this->assertEquals('hashed_new_password', $user->password);
    }

    /** @test */
    public function update_password_invalid_data_basic()
    {
        $user = $this->createUser();
        $data = [
            'current_password'      => '',
            'password'              => 'password',
            'password_confirmation' => 'asasdasd',
        ];

        $response = $this->actingAs($user)
                         ->put('/account/settings/password', $data);

        $response->assertSessionHasErrors([
            'current_password' => 'The current password field is required.',
            'password'         => 'The password confirmation does not match.',
        ]);
    }

    /** @test */
    public function update_password_invalid_current_password()
    {
        $user = $this->createUser();
        $data = [
            'current_password'      => 'invalid_current_password',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->actingAs($user)
                         ->put('/account/settings/password', $data);

        $response->assertSessionHasErrors([
            'current_password' => 'The current password is invalid.',
        ]);
    }
}
