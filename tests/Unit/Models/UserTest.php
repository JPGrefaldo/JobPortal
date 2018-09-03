<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\EmailVerificationCode;
use App\Models\Role;
use App\Models\Site;
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

    /**
     * @test
     */
    public function isConfirmed()
    {
        $this->assertTrue($this->user->isConfirmed());
    }

    /**
     * @test
     */
    public function isActive()
    {
        $this->assertTrue($this->user->isActive());
    }

    /**
     * @test
     */
    public function confirm()
    {
        $this->assertTrue($this->user->isConfirmed());
        $this->user->update(['confirmed' => 0]);
        $this->assertFalse($this->user->isConfirmed());
        $this->user->confirm();
        $this->assertTrue($this->user->isConfirmed());
    }

    /**
     * @test
     */
    public function deactivate()
    {
        $this->assertTrue($this->user->isActive());
        $this->user->deactivate();
        $this->assertFalse($this->user->isActive());
    }

    /**
     * @test
     */
    public function hasRole()
    {
        // given
        $role = factory(Role::class)->create();
        $randomRole = factory(Role::class)->create();

        // when
        $this->user->roles()->save($role);

        // then
        $this->assertTrue($this->user->hasRole($role->name));
        $this->assertFalse($this->user->hasRole($randomRole->name));
    }

    /**
     * @test
     */
    public function hasSite()
    {
        // given
        $site = factory(Site::class)->create();
        $randomSite = factory(Site::class)->create();

        // when
        $this->user->sites()->attach($site);

        // then
        $this->assertTrue($this->user->hasSite($site->hostname));
        $this->assertFalse($this->user->hasSite($randomSite->hostname));
    }

    /**
     * @test
     */
    public function getFormattedPhoneNumberAttribute()
    {
        // given
        $this->user->update(['phone' => '1234567891']);

        // when
        $formattedPhoneNumber = $this->user->formatted_phone_number;

        // then
        $this->assertEquals('(123) 456-7891', $formattedPhoneNumber);
    }
}
