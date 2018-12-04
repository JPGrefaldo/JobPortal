<?php

namespace Tests\Feature\Crew;

use App\Models\Crew;
use App\Models\User;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class MessengerFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;
    /**
     * @test
     */
    public function crew_can_reply()
    {
        // given
        $crew = factory(User::class)->states('withCrewRole')->create();
        $producer = factory(User::class)->create();
        $thread = factory(Thread::class)->create();
        $thread->addParticipant($producer->id);
        $producerMessage = factory(Message::class)->create([
            'user_id' => $producer->id,
        ]);
        $thread->addParticipant($crew->id);
        // $crewReply = factory(Message::class)->create([
        //     'user_id' => $producer->id,
        // ]);

        // when
        $response = $this
            ->actingAs($crew)
            ->postJson(route('crew.messages.store'));

        // then
        $response->assertSee('Producer messaged successfully.');
    }

    /**
     * @test
     */
    public function crew_cannot_initiate()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
        // given
        // crew

        // when
        // crew tries to create a message thread

        // then
        // crew is forbidden
    }

    /**
     * @test
     */
    public function crew_gets_an_email_when_messaged()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
        // given
        // crew

        // when
        // crew is messaged

        // then
        // crew gets the email
    }
}
