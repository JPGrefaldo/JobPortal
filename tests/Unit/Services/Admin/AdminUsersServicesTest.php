<?php

namespace Tests\Unit\Services\Admin;

use App\Services\Admin\AdminUsersServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class AdminUsersServicesTest extends TestCase
{
    /**
     * @var \App\Services\Admin\AdminUsersServices
     */
    protected $service;

    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(AdminUsersServices::class);
    }

    /**
     * @test
     * @covers \App\Services\Admin\AdminUsersServices::ban
     */
    public function ban()
    {
        $user = $this->createUser();

        $this->service->ban('some reason', $user);

        $user->refresh();

        $this->assertArraySubset(
            [
                'user_id' => $user->id,
                'reason'  => 'some reason',
            ],
            $user->banned->toArray()
        );

        $this->assertFalse($user->isActive());
    }
}
