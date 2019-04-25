<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Carbon\Carbon;
use App\Models\PendingFlagMessage;

class PendingFlagMessageFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function test_only_admin_can_see_pending_flag_messages()
    {
        $pendingFlaggedMessage = factory(\App\Models\PendingFlagMessage::class)->create([
            'approved_at'    => null,
            'disapproved_at' => null,
            'status'         => PendingFlagMessage::PENDING,
        ]);

        $approveFlaggedMessage = factory(\App\Models\PendingFlagMessage::class)->create([
            'approved_at'    => Carbon::now(),
            'disapproved_at' => null,
            'status'         => PendingFlagMessage::APPROVED,
        ]);

        $disapprovedFlaggedMessage = factory(\App\Models\PendingFlagMessage::class)->create([
            'approved_at'    => null,
            'disapproved_at' => Carbon::now(),
            'status'         => PendingFlagMessage::UNAPPROVED,
        ]);
        
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->get(route('admin.messages.flagged.index'))
            ->assertSuccessful();

        $response = $this->actingAs($admin, 'api')
            ->get(route('admin.messages.flagged'))
            ->assertSuccessful();

            $response->assertExactJson([
                "data" => [
                    [
                        "approved_at"    => null,
                        "disapproved_at" => null,
                        "id"             => $pendingFlaggedMessage->id,
                        "message"        => $pendingFlaggedMessage->message->body,
                        "message_id"     => $pendingFlaggedMessage->message_id,
                        "message_owner"  => $pendingFlaggedMessage->message->user->nickname,
                        "reason"         => $pendingFlaggedMessage->reason,
                        "thread"         => $pendingFlaggedMessage->message->thread->subject
                    ]
                ]
            ]);
    
            // not sure if this is still needed
            $response->assertJsonMissing([
                $approveFlaggedMessage,
                $disapprovedFlaggedMessage
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
}
