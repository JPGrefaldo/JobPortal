<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\UserBanned;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class UserBannedTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     * @covers \App\Models\UserBanned::user
     */
    public function user()
    {
        $user = $this->createUser();
        UserBanned::create([
            'user_id' => $user->id,
            'reason'  => 'Naughty',
        ]);

        $this->assertEquals($user->last_name, UserBanned::get()->first()->user->last_name);
    }
}
