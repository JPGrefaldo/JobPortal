<?php

namespace Tests\Unit\Services\Admin;

use App\Actions\Admin\ApproveFlagMessage;
use App\Models\PendingFlagMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ApproveFlagMessageTest extends TestCase
{
    /**
     * @var \App\Actions\Admin\ApproveFlagMessage
     */
    protected $service;

    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(ApproveFlagMessage::class);
    }

    /**
     * @test
     * @covers \App\Actions\Admin\ApproveFlagMessage::execute
     */
    public function execute()
    {
        $pendingFlagMessage = factory(PendingFlagMessage::class)->create();

        $this->assertNull($pendingFlagMessage->approved_at);
        $this->assertNull($pendingFlagMessage->message->flagged_at);

        $this->service->execute($pendingFlagMessage);
        $pendingFlagMessage->refresh();
        $pendingFlagMessage->message->refresh();

        $this->assertNotNull($pendingFlagMessage->approved_at);
        $this->assertNotNull($pendingFlagMessage->message->flagged_at);
    }
}
