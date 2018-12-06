<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\UserBanned;
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

    /**
     * @test
     * @covers 
     */
    public function user()
    {
        $user = $this->createUser();
        UserBanned::create([
            'user_id' => $user->id,
            'reason' => 'Naughty',
        ]);

        $this->assertEquals($user->last_name, UserBanned::get()->first()->user->last_name);
    }
}
