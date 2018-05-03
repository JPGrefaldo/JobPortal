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

    /** @test */
    public function update_name()
    {
        $user = $this->createUser();
        $data = [
            'first_name' => 'AdAm james',
            'last_name'  => 'FOrd',
        ];

        $response = $this->actingAs($user)->put('/account/settings/name', $data);

        $response->assertSuccessful();

        $user->refresh();

        $this->assertArraySubset(
            [
                'first_name' => 'Adam James',
                'last_name'  => 'Ford',
            ],
            $user->toArray()
        );
    }

    /** @test */
    public function update_name_first_name_only()
    {
        $user = $this->createUser();
        $data = [
            'first_name' => 'AdAm james',
            'last_name'  => $user->last_name,
        ];

        $response = $this->actingAs($user)->put('/account/settings/name', $data);

        $response->assertSuccessful();

        $user->refresh();

        $this->assertArraySubset(
            [
                'first_name' => 'Adam James',
                'last_name'  => $user->last_name,
            ],
            $user->toArray()
        );
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
            'receive_email_notification' => 1,
            'receive_other_emails'       => 1,
            'receive_sms'                => 1,
        ];

        $response = $this->actingAs($user)->put('/account/settings/notifications', $data);

        $this->assertArraySubset(
            [
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
        $user = $this->createUser();

        factory(UserNotificationSetting::class)->create([
            'user_id'     => $user->id,
            'receive_sms' => 0,
        ]);

        $data = [];

        $response = $this->actingAs($user)->put('/account/settings/notifications', $data);

        $this->assertArraySubset(
            [
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
        $user = $this->createUser();

        factory(UserNotificationSetting::class)->create([
            'user_id'     => $user->id,
            'receive_sms' => 0,
        ]);

        $data = ['receive_other_emails' => 1];

        $response = $this->actingAs($user)->put('/account/settings/notifications', $data);

        $this->assertArraySubset(
            [
                'receive_email_notification' => false,
                'receive_other_emails'       => true,
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
            'receive_email_notification' => 'asdasd',
            'receive_other_emails'       => 'asdasd',
            'receive_sms'                => 'asdasd',
        ];

        $response = $this->actingAs($user)->put('/account/settings/notifications', $data);

        $response->assertSessionHasErrors([
            'receive_email_notification',
            'receive_other_emails',
            'receive_sms',
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

        Hash::shouldReceive('make')->once()->andReturn('hashed_new_password');
        Hash::makePartial();

        $response = $this->actingAs($user)->put('/account/settings/password', $data);

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

        $response = $this->actingAs($user)->put('/account/settings/password', $data);

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

        $response = $this->actingAs($user)->put('/account/settings/password', $data);

        $response->assertSessionHasErrors([
            'current_password' => 'The current password is invalid.',
        ]);
    }
}
