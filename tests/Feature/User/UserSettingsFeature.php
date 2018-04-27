<?php

namespace Tests\Feature\User;

use App\Models\UserNotificationSetting;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSettingsFeature extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

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
            'receive_sms'
        ]);
    }
}
