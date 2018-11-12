<?php

namespace Tests\Feature\Producer;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class MessengerFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     */
    public function producer_can_send_message_to_a_crew_who_applied()
    {
        // $this->withoutExceptionHandling();
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $crew = factory(User::class)->states('withCrewRole')->create();
        $data = [
            'subject' => 'Some subject',
            'message' => 'Some message',
            'recipents' => [
                $crew->id,
            ]
        ];

        // when
        $response = $this
            ->actingAs($producer)
            ->postJson(route('messages.store'), $data);

        // then
        $response->assertSee('Message Sent');
    }

    /**
     * @test
     */
    public function producer_cant_send_message_to_crew_who_has_not_applied()
    {
        // $this->withoutExceptionHandling();
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $randomCrew = factory(User::class)->states('withCrewRole')->create();
        $data = [
            'subject' => 'Some subject',
            'message' => 'Some message',
            'recipents' => [
                $randomCrew->id,
            ]
        ];

        // when
        $response = $this
            ->actingAs($producer)
            ->postJson(route('messages.store'), $data);

        // then
        $response->assertSee('Message not sent.');
    }

    /**
     * @test
     */
    public function producer_can_send_message_to_multiple_crews_who_applied()
    {
        // given
        // producer
        // crews that applied

        // when
        // procuder is trying to send message to crews

        // then
        // producer sees a toast that all of them are messaged
    }
}
