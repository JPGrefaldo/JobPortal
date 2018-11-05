<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessengerFeatureTest extends TestCase
{
    /**
     * @test
     */
    public function producer_is_messaged_when_project_is_denied()
    {
        // given
        // admin
        // producer
        // project of producer

        // when
        // admin denies the project of the producer

        // then
        // admin sees a message that producer is notified that he denied producer's project request
    }
}
