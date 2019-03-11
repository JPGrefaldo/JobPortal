<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\EmailVerificationCode;
use App\Models\Site;
use App\Models\UserBanned;
use App\Models\UserNotificationSetting;
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

        $this->user = $this->createUser();
    }

    /**
     * @test
     * @covers \App\Models\User::sites
     */
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
     * @covers \App\Models\User::notificationSettings
     */
    public function notificationSettings()
    {
        $userNotificationSetting = factory(UserNotificationSetting::class)
            ->create(['user_id' => $this->user->id]);

        $this->assertEquals(
            $userNotificationSetting->id,
            $this->user->notificationSettings->id
        );
    }

    /**
     * @test
     * @covers \App\Models\User::emailVerificationCode
     */
    public function emailVerificationCode()
    {
        $emailVerificationCode = factory(EmailVerificationCode::class)
            ->create(['user_id' => $this->user->id]);

        $this->assertEquals(
            $emailVerificationCode->id,
            $this->user->emailVerificationCode->id
        );
    }

    /**
     * @test
     * @covers \App\Models\User::banned
     */
    public function banned()
    {
        $userBanned = factory(UserBanned::class)
            ->create(['user_id' => $this->user->id]);

        $this->assertEquals($userBanned->id, $this->user->banned->id);
    }

    /**
     * @test
     * @covers \App\Models\User::crew
     */
    public function crew()
    {
        $crew = factory(Crew::class)->create(['user_id' => $this->user->id]);

        $this->assertEquals($crew->id, $this->user->crew->id);
    }

    // TODO: test projects

    /**
     * @test
     * @covers \App\Models\User::isConfirmed
     */
    public function isConfirmed()
    {
        $this->assertTrue($this->user->isConfirmed());
    }

    /**
     * @test
     * @covers \App\Models\User::isActive
     */
    public function isActive()
    {
        $this->assertTrue($this->user->isActive());
    }

    /**
     * @test
     * @covers \App\Models\User::confirm
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
     * @covers \App\Models\User::deactivate
     */
    public function deactivate()
    {
        $this->assertTrue($this->user->isActive());
        $this->user->deactivate();
        $this->assertFalse($this->user->isActive());
    }

    /**
     * @test
     * @covers \App\Models\User::hasSite
     */
    public function hasSite()
    {
        $site = factory(Site::class)->create();
        $randomSite = factory(Site::class)->create();

        $this->user->sites()->attach($site);

        $this->assertTrue($this->user->hasSite($site->hostname));
        $this->assertFalse($this->user->hasSite($randomSite->hostname));
    }

    /**
     * @test
     * @covers \App\Models\User::getFormattedPhoneNumberAttribute
     */
    public function getFormattedPhoneNumberAttribute()
    {
        $this->user->update(['phone' => '1234567891']);

        $formattedPhoneNumber = $this->user->formatted_phone_number;

        $this->assertEquals('(123) 456-7891', $formattedPhoneNumber);
    }

    // TODO: get full name attribute

    // TODO: get nickname attribute

    /**
     * @test
     * @covers \App\Models\User::getNicknameOrFullNameAttribute
     */
    public function getNicknameOrFullNameAttribute_with_nickname()
    {
        $this->user->update([
            'nickname' => 'The Rock',
        ]);

        $this->assertEquals('The Rock', $this->user->NicknameOrFull_Name);
    }

    /**
     * @test
     * @covers \App\Models\User::getNicknameOrFullNameAttribute
     */
    public function getNicknameOrFullNameAttribute_without_nickname()
    {
        $this->user->update([
            'nickname' => '',
        ]);

        $this->assertEquals($this->user->full_name, $this->user->NicknameOrFullName);
    }

    // TODO: scope are crew

    // TODO: scope are producer
}
