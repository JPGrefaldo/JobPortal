<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\StubUserNotifications;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StubUserNotificationsTest extends TestCase
{
    use DatabaseMigrations, SeedDatabaseAfterRefresh;

    /**
     * @var StubUserNotifications
     */
    public $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(StubUserNotifications::class);
    }

    /**
     * @test
     * @covers \App\Actions\Auth\StubUserNotifications::execute
     */
    public function valid_receive_sms_data()
    {
        $user = $this->createUser();
        $data = ['receive_sms' => 1];

        $this->service->execute($user, $data);

        $this->assertDatabaseHas('user_notification_settings', [
            'user_id'     => 1,
            'receive_sms' => 1,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Auth\StubUserNotifications::execute
     */
    public function invalid_receive_sms_data()
    {
        $user = $this->createUser();
        $data = [];

        $this->service->execute($user, $data);

        $this->assertDatabaseHas('user_notification_settings', [
            'user_id'     => 1,
            'receive_sms' => 0,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Auth\StubUserNotifications::execute
     */
    public function do_not_receive_sms_data()
    {
        $user = $this->createUser();
        $data = ['receive_sms' => 0];

        $this->service->execute($user, $data);

        $this->assertDatabaseHas('user_notification_settings', [
            'user_id'     => 1,
            'receive_sms' => 0,
        ]);
    }
}
