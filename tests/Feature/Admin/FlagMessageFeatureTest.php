<?php

namespace Tests\Feature;

use App\Models\PendingFlagMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class FlagMessageFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;
    /**
     * @test
     * @cover \App\Http\Controllers\FlagMessageController::update
     */
    public function approvePendingFlagMessage()
    {
        // given
        $admin = $this->createAdmin();
        $pendingFlagMessage = factory(PendingFlagMessage::class)->create();

        $data = [
            'pending_flag_message_id' => $pendingFlagMessage->id,
            'action' => 'approve',
        ];

        // when
        $response = $this->actingAs($admin)
            ->putJson(route('pending-flag-messages.update'), $data);

        // then
        $response->assertSee('Pending flag message approved');
    }

    /**
     * @test
     * @cover \App\Http\Controllers\FlagMessageController::update
     */
    public function disapprovePendingFlagMessage()
    {
        // given
        $admin = $this->createAdmin();
        $pendingFlagMessage = factory(PendingFlagMessage::class)->create();

        $data = [
            'pending_flag_message_id' => $pendingFlagMessage->id,
            'action' => 'disapprove',
        ];

        // when
        $response = $this->actingAs($admin)
            ->putJson(route('pending-flag-messages.update'), $data);

        // then
        $response->assertSee('Pending flag message disapproved');
    }
}
