<?php

namespace Tests\Unit\Services;

use App\User;
use App\UserBanned;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserBannedTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function user()
    {
        $user = factory(User::class)->create();
        UserBanned::create([
            'user_id' => $user->id,
            'reason' => 'Naughty',
        ]);

        $this->assertEquals($user->last_name, UserBanned::get()->first()->user->last_name);
    }
}
