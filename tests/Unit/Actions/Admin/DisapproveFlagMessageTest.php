<?php

namespace Tests\Unit\Services\Admin;

use App\Actions\Admin\DisapproveFlagMessage;
use App\Models\PendingFlagMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class DisapproveFlagMessageTest extends TestCase
{
    /**
     * @var \App\Actions\Admin\DisapproveFlagMessage
     */
    protected $service;

    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(DisapproveFlagMessage::class);
    }

    /**
     * @test
     * @covers \App\Actions\Admin\DisapproveFlagMessage::execute
     */
    public function execute()
    {
        $pendingFlagMessage = factory(PendingFlagMessage::class)->create();

        $this->assertNull($pendingFlagMessage->disapproved_at);

        $this->service->execute($pendingFlagMessage);
        $pendingFlagMessage->refresh();

        $this->assertNotNull($pendingFlagMessage->disapproved_at);
    }
}
