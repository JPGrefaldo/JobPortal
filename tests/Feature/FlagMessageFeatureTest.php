<?php

namespace Tests\Feature;

use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class FlagMessageFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\MessageController::update
     */
    public function crewFlagProducerMessage()
    {
        // given
        $crew = $this->createCrew();
        $producer = $this->createProducer();
        $thread = factory(Thread::class)->create();

        $thread->addParticipant([$producer->id, $crew->id]);

        $foulMessage = factory(Message::class)->create([
            'thread_id' => $thread->id,
            'user_id' => $producer->id,
            'body' => 'Glip-Glop',
        ]);

        $data = [
            'reason' => 'Glip-Glop is a derogatory term for Traflorkians',
        ];

        // when
        $response = $this->actingAs($crew)
            ->putJson(route('messages.update', $foulMessage), $data);

        // then
        $response->assertSee('Reviewing your request for flag');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\MessageController::update
     */
    public function producerFlagCrewMessage()
    {
        // given
        $producer = $this->createProducer();
        $crew = $this->createCrew();
        $thread = factory(Thread::class)->create();

        $thread->addParticipant([$producer->id, $crew->id]);

        $foulMessage = factory(Message::class)->create([
            'thread_id' => $thread->id,
            'user_id' => $crew->id,
            'body' => 'Glip-Glop',
        ]);

        $data = [
            'reason' => 'Glip-Glop is a derogatory term for Traflorkians',
        ];

        // when
        $response = $this->actingAs($producer)
            ->putJson(route('messages.update', $foulMessage), $data);

        // then
        $response->assertSee('Reviewing your request for flag');
    }
}
