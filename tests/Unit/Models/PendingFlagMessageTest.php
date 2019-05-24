<?php

namespace Tests\Unit\Models;

use App\Models\Message;
use App\Models\PendingFlagMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PendingFlagMessageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @covers \App\Models\PendingFlagMessage::message
     */
    public function message()
    {
        // given
        $message = factory(Message::class)->create();

        // when
        $pendingFlagMessage = factory(PendingFlagMessage::class)->create([
            'message_id' => $message->id,
        ]);

        // then
        $this->assertEquals(
            $message->body,
            $pendingFlagMessage->message->body
        );
    }
}
