<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\UserNotificationSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserNotificationSettingTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $userNotificationSetting;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->userNotificationSetting =
            factory(UserNotificationSetting::class)
                ->create(['user_id' => $this->user->id]);
    }

    /**
     * @test
     * @covers \App\Models\UserNotificationSetting::user
     */
    public function user()
    {
        $this->assertEquals(
            $this->user->email,
            $this->userNotificationSetting->user->email
        );
    }
}
