<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\UserNotificationSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserNotificationSettingTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->userNotificationSetting =
            factory(UserNotificationSetting::class)
                ->create(['user_id' => $this->user->id]);
    }

    /**
     * @test
     */
    public function user()
    {
        $this->assertEquals(
            $this->user->email,
            $this->userNotificationSetting->user->email
        );
    }
}
