<?php

namespace Tests\Feature\Crew;

use App\Models\Message;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class MessengerFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\MessageController::store
     */
    public function crew_can_reply()
    {
        $crew = $this->createCrew();
        $producer = $this->createProducer();
        $thread = factory(Thread::class)->create();
        $thread->addParticipant($producer->id);
        factory(Message::class)->create([
            'user_id' => $producer->id,
        ]);
        $thread->addParticipant($crew->id);

        $response = $this
            ->actingAs($crew)
            ->postJson(route('crew.messages.store'));

        $response->assertSee('Producer messaged successfully.');
    }
}
