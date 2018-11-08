<?php

namespace Tests\Feature\Producer;

use Tests\TestCase;

class MessengerFeatureTest extends TestCase
{
    /**
     * @test
     */
    public function producer_can_send_message_to_a_crew_who_applied()
    {
        // given
        // producer
        // crew that applied to position

        // when
        // producer is sending a message to crew

        // then
        // producer sees toast that message was sent
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
