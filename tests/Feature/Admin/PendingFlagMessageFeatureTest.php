<?php

namespace Tests\Feature\Admin;

use App\Models\PendingFlagMessage;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class PendingFlagMessageFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    private function getPendingFlaggedMessage()
    {
        return [
            'approved_at'    => null,
            'disapproved_at' => null,
            'status'         => PendingFlagMessage::UNAPPROVED,
        ];
    }

    private function getApprovedFlagMessage()
    {
        return [
            'approved_at'    => Carbon::now(),
            'disapproved_at' => null,
            'status'         => PendingFlagMessage::APPROVED,
        ];
    }

    private function getDisapprovedFlagMessage()
    {
        return [
            'approved_at'    => null,
            'disapproved_at' => Carbon::now(),
            'status'         => PendingFlagMessage::UNAPPROVED,
        ];
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Api\Admin\FlagMessageController::index
     */
    public function admin_can_see_pending_flag_messages()
    {
        $pendingFlagMessage = factory(PendingFlagMessage::class)->create(
            $this->getPendingFlaggedMessage()
        );

        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->get(route('admin.messages.flagged.index'))
            ->assertSuccessful();

        $response = $this->actingAs($admin, 'api')
            ->get(route('admin.messages.flagged'))
            ->assertSuccessful();

        $response->assertJson([
            "data" => [
                [
                    "id"             => $pendingFlagMessage->id,
                    "message"        => $pendingFlagMessage->message->body,
                    "message_id"     => $pendingFlagMessage->message_id,
                    "message_owner"  => $pendingFlagMessage->message->user->nickname,
                    "reason"         => $pendingFlagMessage->reason,
                    "thread"         => $pendingFlagMessage->message->thread->subject,
                    "approved_at"    => null,
                    "disapproved_at" => null,
                ]
            ]
        ]);
    }

    /**
     * @test
     *
     * @covers \App\Http\Controllers\PendingFlagMessageController::index
     * @covers \App\Http\Controllers\Api\Admin\FlagMessageController::index
     */
    public function crew_is_not_allowed_to_see_flagged_messages()
    {
        $crew = $this->createCrew();

        $this->actingAs($crew)
            ->get(route('admin.messages.flagged.index'))
            ->assertForbidden();

        $this->actingAs($crew, 'api')
            ->get(route('admin.messages.flagged'))
            ->assertForbidden();
    }

    /**
     * @test
     *
     * @covers \App\Http\Controllers\PendingFlagMessageController::index
     * @covers \App\Http\Controllers\Api\Admin\FlagMessageController::index
     */
    public function producer_is_not_allowed_to_see_flagged_messages()
    {
        $producer = $this->createProducer();

        $this->actingAs($producer)
            ->get(route('admin.messages.flagged.index'))
            ->assertForbidden();

        $this->actingAs($producer, 'api')
            ->get(route('admin.messages.flagged'))
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\PendingFlagMessageController::update
     */
    public function admin_can_approve_pending_flag_message()
    {
        $pendingFlagMessage = factory(PendingFlagMessage::class)->create($this->getPendingFlaggedMessage());

        $this->assertEquals(PendingFlagMessage::UNAPPROVED, $pendingFlagMessage->status);

        $this->actingAs($this->createAdmin())
            ->put(route('pending-flag-messages.update', $pendingFlagMessage), [
                'action' => 'approve'
            ])
            ->assertSee('Pending flag message approved')
            ->assertOk();

        $this->assertEquals(PendingFlagMessage::APPROVED, $pendingFlagMessage->refresh()->status);
        $this->assertNull($pendingFlagMessage->refresh()->unapproved_at);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\PendingFlagMessageController::update
     */
    public function admin_can_disapprove_pending_flag_message()
    {
        $pendingFlagMessage = factory(PendingFlagMessage::class)->create($this->getPendingFlaggedMessage());

        $this->assertEquals(PendingFlagMessage::UNAPPROVED, $pendingFlagMessage->status);

        $this->actingAs($this->createAdmin())
            ->put(route('pending-flag-messages.update', $pendingFlagMessage), [
                'action' => 'disapprove'
            ])
            ->assertSee('Pending flag message disapproved')
            ->assertOk();

        $this->assertEquals(PendingFlagMessage::UNAPPROVED, $pendingFlagMessage->refresh()->status);
        $this->assertNull($pendingFlagMessage->refresh()->approved_at);
    }
}
