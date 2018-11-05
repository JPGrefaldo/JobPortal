<?php

namespace Tests\Feature\Crew;

use Tests\TestCase;

class MessengerFeatureTest extends TestCase
{
    /**
     * @test
     */
    public function crew_can_reply()
    {
        // given
        // message from producer
        // crew

        // when
        // crew tires to reply to producer

        // then
        // crew sees theat his reply was sent
    }

    /**
     * @test
     */
    public function crew_cannot_initiate()
    {
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
        // given
        // crew

        // when
        // crew is messaged

        // then
        // crew gets the email
    }
}
