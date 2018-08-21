<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\EmailVerificationCode;
use App\Models\Role;
use App\Models\User;
use App\Models\UserBanned;
use App\Models\UserNotificationSetting;
use App\Models\UserRoles;
use App\Models\UserSites;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function roles()
    {
        $role = Role::whereName(Role::PRODUCER)->firstOrFail();
        UserRoles::create([
            'user_id' => $this->user->id,
            'role_id' => $role->id,
        ]);

        $this->assertEquals(1, $this->user->roles->count());
        $this->assertEquals("Producer", $this->user->roles->first()->name);
    }

    /** @test */
    public function sites()
    {
        $site = $this->getCurrentSite();
        UserSites::create([
            'user_id' => $this->user->id,
            'site_id' => $site->id,
        ]);

        $this->assertEquals(1, $this->user->sites->count());
        $this->assertEquals($site->name, $this->user->sites->first()->name);
    }

    /**
     * @test
     */
    public function notificationSettings()
    {
        // when
        $userNotificationSetting = factory(UserNotificationSetting::class)
            ->create(['user_id' => $this->user->id]);

        // then
        $this->assertEquals(
            $userNotificationSetting->id,
            $this->user->notificationSettings->id
        );
    }

    /**
     * @test
     */
    public function emailVerificationCode()
    {
        // when
        $emailVerificationCode = factory(EmailVerificationCode::class)
            ->create(['user_id' => $this->user->id]);

        // then
        $this->assertEquals(
            $emailVerificationCode->id,
            $this->user->emailVerificationCode->id
        );
    }

    /**
     * @test
     */
    public function banned()
    {
        // when
        $userBanned = factory(UserBanned::class)
            ->create(['user_id' => $this->user->id]);

        // then
        $this->assertEquals($userBanned->id, $this->user->banned->id);
    }

    /**
     * @test
     */
    public function crew()
    {
        // when
        $crew = factory(Crew::class)->create(['user_id' => $this->user->id]);

        // then
        $this->assertEquals($crew->id, $this->user->crew->id);
    }
}
