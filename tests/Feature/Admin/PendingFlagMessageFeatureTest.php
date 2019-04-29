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

    public function getPendingFlaggedMessage()
    {
        return [
            'approved_at'    => null,
            'disapproved_at' => null,
            'status'         => PendingFlagMessage::UNAPPROVED,
        ];
    }

    public function getApprovedFlagMessage()
    {
        return [
            'approved_at'    => Carbon::now(),
            'disapproved_at' => null,
            'status'         => PendingFlagMessage::APPROVED,
        ];
    }

    public function getDisapprovedFlagMessage()
    {
        return [
            'approved_at'    => null,
            'disapproved_at' => Carbon::now(),
            'status'         => PendingFlagMessage::UNAPPROVED,
        ];
    }

    public function test_only_admin_can_see_pending_flag_messages()
    {
        $pendingFlagMessage = factory(\App\Models\PendingFlagMessage::class)->create(
            $this->getPendingFlaggedMessage()
        );

        $approvedFlagMessage = factory(\App\Models\PendingFlagMessage::class)->create(
            $this->getApprovedFlagMessage()
        );

        $disapprovedFlagMessage = factory(\App\Models\PendingFlagMessage::class)->create(
            $this->getDisapprovedFlagMessage()
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
                    "approved_at"    => null,
                    "disapproved_at" => null,
                    "id"             => $pendingFlagMessage->id,
                    "message"        => $pendingFlagMessage->message->body,
                    "message_id"     => $pendingFlagMessage->message_id,
                    "message_owner"  => $pendingFlagMessage->message->user->nickname,
                    "reason"         => $pendingFlagMessage->reason,
                    "thread"         => $pendingFlagMessage->message->thread->subject
                ]
            ]
        ]);

        // not sure if this is still needed
        $response->assertJsonMissing([
            $approvedFlagMessage,
            $disapprovedFlagMessage
        ]);
    }

    /**
     * @test
     *
     * @covers \App\Http\Controllers\PendingFlagMessageController
     * @covers \App\Http\Controllers\Api\Admin\FlagMessagesController
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
     * @covers \App\Http\Controllers\PendingFlagMessageController
     * @covers \App\Http\Controllers\Api\Admin\FlagMessagesController
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
     * @covers \App\Http\Controllers\PendingFlagMessageController
     */
    public function can_approve_pending_flag_message()
    {
        $pendingFlagMessage = factory(PendingFlagMessage::class)->create($this->getPendingFlaggedMessage());

        $this->assertEquals(PendingFlagMessage::UNAPPROVED, $pendingFlagMessage->status);

        $this->actingAs($this->createAdmin())
            ->put(route('pending-flag-messages.update', $pendingFlagMessage->id), [
                'action' => 'approve'
            ])
            ->assertSee('Pending flag message approved')
            ->assertOk();

        $this->assertEquals(PendingFlagMessage::APPROVED, $pendingFlagMessage->refresh()->status);
        $this->assertNull($pendingFlagMessage->refresh()->unapproved_at);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\PendingFlagMessageController
     */
    public function can_disapprove_pending_flag_message()
    {
        $pendingFlagMessage = factory(PendingFlagMessage::class)->create($this->getPendingFlaggedMessage());

        $this->assertEquals(PendingFlagMessage::UNAPPROVED, $pendingFlagMessage->status);

        $this->actingAs($this->createAdmin())
            ->put(route('pending-flag-messages.update', $pendingFlagMessage->id), [
                'action' => 'disapprove'
            ])
            ->assertSee('Pending flag message disapproved')
            ->assertOk();

        $this->assertEquals(PendingFlagMessage::UNAPPROVED, $pendingFlagMessage->refresh()->status);
        $this->assertNull($pendingFlagMessage->refresh()->approved_at);
    }
}
