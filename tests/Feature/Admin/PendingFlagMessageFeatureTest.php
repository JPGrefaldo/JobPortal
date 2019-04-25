<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Illuminate\Http\Response;

class PendingFlagMessageFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function test_only_admin_can_see_pending_flag_messages()
    {
        $pendingFlaggedMessage = factory(\App\Models\PendingFlagMessage::class)->create([
            'approved_at'    => null,
            'disapproved_at' => null
        ]);

        $approveFlaggedMessage = factory(\App\Models\PendingFlagMessage::class)->create([
            'approved_at'    => \Carbon\Carbon::now(),
            'disapproved_at' => null
        ]);

        $disapprovedFlaggedMessage = factory(\App\Models\PendingFlagMessage::class)->create([
            'approved_at'    => null,
            'disapproved_at' => \Carbon\Carbon::now()
        ]);
        
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->get(route('admin.flag-messages.index'))
            ->assertSuccessful();

        $response = $this->actingAs($admin, 'api')
            ->get(route('admin.projects.flag-messages'))
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

    public function test_crew_is_not_allowed_to_see_flag_messages()
    {
        $crew = $this->createCrew();

        $this->actingAs($crew)
            ->get(route('admin.flag-messages.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->actingAs($crew, 'api')
            ->get(route('admin.projects.flag-messages'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_producer_is_not_allowed_to_see_flag_messages()
    {
        $producer = $this->createProducer();

        $this->actingAs($producer)
            ->get(route('admin.flag-messages.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->actingAs($producer, 'api')
            ->get(route('admin.projects.flag-messages'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
