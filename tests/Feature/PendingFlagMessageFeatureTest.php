<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\Participant;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class PendingFlagMessageFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\PendingFlagMessageController::store
     */
    public function crew_flag_producer_message()
    {
        // given
        $crew = $this->createCrew();
        $producer = $this->createProducer();
        $thread = factory(Thread::class)->create();

        factory(Participant::class)->create([
            'thread_id' => $thread->id,
            'user_id'   => $producer->id,
        ]);

        factory(Participant::class)->create([
            'thread_id' => $thread->id,
            'user_id'   => $crew->id,
        ]);

        $foulMessage = factory(Message::class)->create([
            'thread_id' => $thread->id,
            'user_id'   => $producer->id,
            'body'      => 'Glip-Glop',
        ]);

        $data = [
            'message_id' => $foulMessage->id,
            'reason'     => 'Glip-Glop is a derogatory term for Traflorkians',
        ];

        // when
        $response = $this->actingAs($crew)
            ->postJson(route('pending-flag-messages.store'), $data);

        // then
        $response->assertSee('Reviewing your request for flag');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\PendingFlagMessageController::store
     */
    public function producer_flag_crew_message()
    {
        // given
        $producer = $this->createProducer();
        $crew = $this->createCrew();
        $thread = factory(Thread::class)->create();

        factory(Participant::class)->create([
            'thread_id' => $thread->id,
            'user_id'   => $producer->id,
        ]);

        factory(Participant::class)->create([
            'thread_id' => $thread->id,
            'user_id'   => $crew->id,
        ]);

        $foulMessage = factory(Message::class)->create([
            'thread_id' => $thread->id,
            'user_id'   => $crew->id,
            'body'      => 'Glip-Glop',
        ]);

        $data = [
            'message_id' => $foulMessage->id,
            'reason'     => 'Glip-Glop is a derogatory term for Traflorkians',
        ];

        // when
        $response = $this->actingAs($producer)
            ->postJson(route('pending-flag-messages.store'), $data);

        // then
        $response->assertSee('Reviewing your request for flag');
    }
}
