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
     * @cover app\HTTP\Controllers\MessageControler::update
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
        $this->actingAs($crew)
            ->putJson(route('messages.update', $foulMessage), $data);

        // then
        $this->assertSee('Reviewing your request for flag');
    }

    /**
     * @test
     * @cover App\HTTP\Controllers\MessageController::update
     */
    public function producerFlagCrewMessage()
    {
        // given
        $producer = $this->createProducer();
        $crew = $this->createCrew();
        $message = 'Hey';

        $producer->message($crew, $message);

        $foulMessage = 'Glip-glop';

        $crew->message($producer, $foulMessage);

        // when
        $this->actingAs($producer)
            ->putJson(route('messages.update', $foulMessage));

        // then
        $this->assertSee('Reviewing your request for flag');
    }
}
