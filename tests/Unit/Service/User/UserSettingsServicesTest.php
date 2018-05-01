<?php

namespace Tests\Unit\Service\User;

use App\Models\UserNotificationSetting;
use App\Services\User\UserSettingsServices;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSettingsServicesTest extends TestCase
{
    /**
     * @var \App\Services\User\UserSettingsServices
     */
    protected $service;

    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(UserSettingsServices::class);
    }

    /** @test */
    public function update_notifications()
    {
        $data = [
            'receive_email_notification' => 1,
            'receive_other_emails'       => 1,
            'receive_sms'                => 1,
        ];
        $notifications = factory(UserNotificationSetting::class)->create(['receive_sms' => 0,]);

        $this->service->updateNotifications($data, $notifications);

        $notifications->refresh();

        $this->assertArraySubset(
            [
                'receive_email_notification' => true,
                'receive_other_emails'       => true,
                'receive_sms'                => true,
            ],
            $notifications->toArray()
        );
    }

    /** @test */
    public function update_notifications_no_data()
    {
        $data = [];
        $notifications = factory(UserNotificationSetting::class)->create();

        $this->service->updateNotifications($data, $notifications);

        $notifications->refresh();

        $this->assertArraySubset(
            [
                'receive_email_notification' => false,
                'receive_other_emails'       => false,
                'receive_sms'                => false,
            ],
            $notifications->toArray()
        );
    }

    /** @test */
    public function update_notifications_only_receive_other_emails()
    {
        $data = ['receive_other_emails' => 1];
        $notifications = factory(UserNotificationSetting::class)->create();

        $this->service->updateNotifications($data, $notifications);

        $notifications->refresh();

        $this->assertArraySubset(
            [
                'receive_email_notification' => false,
                'receive_other_emails'       => true,
                'receive_sms'                => false,
            ],
            $notifications->toArray()
        );
    }
}
