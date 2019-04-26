<?php

namespace Tests\Unit\Services\Admin;

use App\Actions\Admin\BanUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class BanUserTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var \App\Actions\Admin\BanUser
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(BanUser::class);
    }

    /**
     * @test
     * @covers \App\Actions\Admin\BanUser::execute
     */
    public function ban()
    {
        $user = $this->createUser();

        $this->service->execute('some reason', $user);

        $user->refresh();

        $this->assertArrayHas(
            [
                'user_id' => $user->id,
                'reason'  => 'some reason',
            ],
            $user->banned->toArray()
        );

        $this->assertFalse($user->isActive());
    }
}
